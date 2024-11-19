<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\GradingTopic;
use App\Models\Subject;
use App\Models\SubjectGrade;
use App\Models\TopicGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicGradeController extends Controller
{
    public function index($classId)
    {
        $decryptId = decrypt($classId);

        $user = User::with('class.subjects')->find($decryptId);



        if (!$user || !$user->class) {
            return redirect('teacher/dashboard')->with('error', 'User or class not found.');
        }

        $className = $user->class->name;

        $firstLetter = strtoupper(substr($className, 0, 1));

        $departments = [
            'G' => 'График дизайн',
            'S' => 'Программ хангамж',
            'T' => 'Программ хангамж',
            'I' => 'Интерьер дизайн',
        ];

        $department = $departments[$firstLetter];

        $grading_topics = GradingTopic::query()->where('department',$department)->where('status',1)->get();


        $grades = TopicGrade::where('user_id', $decryptId)
            ->get()
            ->keyBy('grading_topic_id');


        $topicsWithGrades = $grading_topics->map(function ($gradingTopic) use ($grades) {
            $grade = $grades->get($gradingTopic->id); // `id` is used as `grading_topic_id`

            return [
                'topic' => $gradingTopic,  // Assuming `name` is a field in `GradingTopic`
                'grade' => $grade ? $grade->grade : 'No Grade'
            ];
        });


        return view('teacher.grade.topic_grade', compact('topicsWithGrades', 'user'));
    }

    public function updateOrCreate(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'topic_id' => 'required',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $grade = TopicGrade::updateOrCreate(
            ['grading_topic_id' => $validatedData['topic_id'], 'user_id' => $validatedData['user_id']],
            ['grade' => $validatedData['score']]
        );

        return redirect()->back()->with('message', 'Grade saved successfully!');
    }

}
