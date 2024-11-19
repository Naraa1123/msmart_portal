<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\GradingTopic;
use App\Models\SchoolClass;
use App\Models\SubjectGrade;
use App\Models\TopicGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectGradeController extends Controller
{
    public function class_choose()
    {
        $user = Auth::user();

        if ($user->role_as == 1) {
            $departmentIds = Department::pluck('id')->toArray();
            $classPlans = [];

            foreach ($departmentIds as $departmentId) {
                $classPlans["department_$departmentId"] = SchoolClass::where('department_id', $departmentId)
                    ->orderBy('name', 'asc')
                    ->get();
            }

            return view('admin.subject_grade.class', compact('classPlans'));
        } else {
            return redirect('/')->with('error', 'You are not authorized to view this page.');
        }
    }

    public function get_student($id)
    {
        $decryptId = decrypt($id);
        $class = SchoolClass::findOrFail($decryptId);

        if ($class) {
            $students = $class->users;
            return view('admin.subject_grade.student', compact('students', 'class'));
        } else {
            return redirect('admin/subject-class')->with('error', 'Class байхгүй байна.');
        }
    }

    public function view_grades($id)
    {
        $decryptId = decrypt($id);

        $user = User::with('class.subjects')->find($decryptId);

        if (!$user || !$user->class) {
            return redirect('admin/subject-grade')->with('error', 'User or class not found.');
        }

        $className = $user->class->name;

        $selectedSubjects = $user->class->subjects;

        $firstLetter = strtoupper(substr($className, 0, 1));

        $departments = [
            'G' => 'График дизайн',
            'S' => 'Программ хангамж',
            'T' => 'Программ хангамж',
            'I' => 'Интерьер дизайн',
        ];

        $department = $departments[$firstLetter];

// Fetch topics
        $gradableTopics = GradingTopic::where('department', $department)->where('status', 1)->get();
        $nonGradableTopics = GradingTopic::where('department', $department)
            ->where('status', 0)
            ->with(['subjects' => function ($query) use ($selectedSubjects) {
                $query->whereIn('id', $selectedSubjects->pluck('subject_id'));
            }])
            ->get();


        $topicGrades = TopicGrade::where('user_id', $decryptId)->get()->keyBy('grading_topic_id');
        $subjectGrades = SubjectGrade::where('user_id', $decryptId)->get()->keyBy('subject_id');

        $unassignedSubjects = $selectedSubjects->filter(function ($classSubject) {
            return is_null($classSubject->subject->grading_topic_id);
        });

        $gradableTopicsWithGrades = $gradableTopics->map(function ($topic) use ($topicGrades) {
            $grade = $topicGrades[$topic->id] ?? null;

            return [
                'topic' => $topic,
                'grade' => $grade ? $grade->grade : 'No Grade',
            ];
        });

        $nonGradableTopicsWithGrades = $nonGradableTopics->map(function ($topic) use ($subjectGrades) {
            $subjectsWithGrades = $topic->subjects->map(function ($subject) use ($subjectGrades) {
                $grade = $subjectGrades[$subject->id] ?? null;

                return [
                    'subject' => $subject,
                    'grade' => $grade ? $grade->grade : 'No Grade',
                ];
            });

            return [
                'topic' => $topic,
                'subjects' => $subjectsWithGrades,
            ];
        });

        $unassignedSubjectsWithGrades = $unassignedSubjects->map(function ($classSubject) use ($subjectGrades) {
            $subject = $classSubject->subject;
            $grade = $subjectGrades[$subject->id] ?? null;

            return [
                'subject' => $subject,
                'grade' => $grade ? $grade->grade : 'No Grade',
            ];
        });

        if ($unassignedSubjectsWithGrades->isNotEmpty()) {
            $nonGradableTopicsWithGrades->push([
                'topic' => (object) ['topic' => 'Ерөнхий судлах хичээл'],
                'subjects' => $unassignedSubjectsWithGrades,
            ]);
        }


        return view('admin.subject_grade.grade', [
            'gradableTopicsWithGrades' => $gradableTopicsWithGrades,
            'nonGradableTopicsWithGrades' => $nonGradableTopicsWithGrades,
            'user' => $user,
        ]);
    }
    public function updateOrCreate(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $grade = SubjectGrade::updateOrCreate(
            ['subject_id' => $validatedData['subject_id'], 'user_id' => $validatedData['user_id']],
            ['grade' => $validatedData['score']]
        );

        return redirect()->back()->with('message', 'Grade saved successfully!');
    }

    public function topicUpdateOrCreate(Request $request)
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
