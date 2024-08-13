<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\SubjectGrade;
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

        $grades = SubjectGrade::where('user_id', $decryptId)
            ->get()
            ->keyBy('subject_id');


        $subjectsWithGrades = $subjects->map(function ($classSubject) use ($grades) {
            $subjectId = $classSubject->subject_id;
            $grade = $grades->get($subjectId);

            return [
                'subject' => $classSubject->subject, // Assuming you have the subject relationship set up
                'grade' => $grade ? $grade->grade : 'No Grade'
            ];
        });

//        dd($subjectsWithGrades);


        return view('admin.subject_grade.grade', compact('subjectsWithGrades','user'));
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
