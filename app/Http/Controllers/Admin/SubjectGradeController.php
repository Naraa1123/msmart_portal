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



        $subjects = $user->class->subjects;

        $gradingTopics = GradingTopic::where('department', $subjects->first()->subject->department)->get();

        $grades = SubjectGrade::where('user_id', $decryptId)
            ->get()
            ->keyBy('subject_id');

// Map subjects to include grade information
        $subjectsWithGrades = $subjects->map(function ($classSubject) use ($grades) {
            $subjectId = $classSubject->subject_id;
            $grade = $grades->get($subjectId);

            return [
                'subject' => $classSubject->subject, // Assuming you have the subject relationship set up
                'grade' => $grade ? $grade->grade : 'No Grade',
                'grading_topic_id' => $classSubject->subject->grading_topic_id, // Grading topic ID may be null
            ];
        });

// Group subjects by grading_topic_id
        $subjectsGroupedByTopic = $gradingTopics->map(function ($topic) use ($subjectsWithGrades) {
            return [
                'topic' => $topic,
                'subjects' => $subjectsWithGrades->filter(function ($subjectWithGrade) use ($topic) {
                    return $subjectWithGrade['grading_topic_id'] === $topic->id;
                })->values(),
            ];
        });

// Add a separate group for subjects with no grading_topic_id
        $unassignedSubjects = $subjectsWithGrades->filter(function ($subjectWithGrade) {
            return is_null($subjectWithGrade['grading_topic_id']);
        })->values();

        $subjectsGroupedByTopic->push([
            'topic' => (object) ['topic' => 'Ерөнхий судлах хичээл'], // Placeholder topic for unassigned subjects
            'subjects' => $unassignedSubjects,
        ]);

        $topic_grades = TopicGrade::where('user_id', $decryptId)->get();

        return view('admin.subject_grade.grade', compact('subjectsGroupedByTopic', 'topic_grades', 'user'));
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



}
