<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassUserController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        if ($teacher->role_as == 2) {
            $teacherClasses = $teacher->teacherClasses;

            return view('teacher.class.index', compact('teacherClasses'));
        } else {

            return redirect('teacher/dashboard')->with('message', 'Таньд багшийн хэсэг рүү нэвтрэх эрх байхгүй байна');
        }
    }

    public function viewStudents($classId)
    {
        $teacher = Auth::user();

        if ($teacher->role_as == 2) {

            $decryptId = decrypt($classId);
            $class = $teacher->teacherClasses->find($decryptId);


            if ($class) {
                $users = $class->users()->whereHas('userDetails', function ($query) {
                    $query->where('status', 'studying');
                })->get();

                return view('teacher.class.student', compact('users'));
            } else {
                return redirect('/')->with('error', 'Class байхгүй байна.');
            }
        } else {
            return redirect('/')->with('error', 'You are not authorized to view this page.');
        }
    }


    public function viewSubjects($classId)
    {
        $teacher = Auth::user();

        if ($teacher->role_as == 2) {
            $decryptId = decrypt($classId);
            $class = $teacher->teacherClasses->find($decryptId);

            if ($class) {
                $subjects = $class->subjects;

                return view('teacher.class.subject', compact('subjects'));
            } else {
                return redirect('/')->with('error', 'Class байхгүй байна.');
            }
        } else {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
        }
    }

    public function changeStatus($id)
    {
        $teacher = Auth::user();
        if ($teacher->role_as == 2) {
            $id = decrypt($id);
            try {
                $classSubject = DB::table('class_subjects')->where('id', $id)->first();
                if ($classSubject) {
                    $newStatus = $classSubject->status == '0' ? '1' : '0';
                    DB::table('class_subjects')
                        ->where('id', $id)
                        ->update(['status' => $newStatus]);

                    return redirect()->back()->with('success', 'Status updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'Record not found.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred.');
            }
        } else {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
        }
    }

    public function viewGrades($id)
    {
//        $teacher = Auth::user();

//        if ($teacher->role_as == 2) {

            $decryptId = decrypt($id);

            $user = User::with('class.subjects')->find($decryptId);

            if (!$user || !$user->class) {
                return redirect('teacher/dashboard')->with('error', 'User or class not found.');
            }

            $subjects = $user->class->subjects;

            $grades = SubjectGrade::where('user_id', $decryptId)
                ->get()
                ->keyBy('subject_id');


            $subjectsWithGrades = $subjects->map(function ($classSubject) use ($grades) {
                $subjectId = $classSubject->subject_id;
                $grade = $grades->get($subjectId);

                return [
                    'subject' => $classSubject->subject,
                    'grade' => $grade ? $grade->grade : 'No Grade'
                ];
            });
//            dd($subjectsWithGrades);

            return view('teacher.class.grade', compact('subjectsWithGrades', 'user'));
//        } else {
//            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
//        }
    }


    public function updateOrCreate(Request $request)
    {
        $teacher = Auth::user();
        if ($teacher->role_as == 2) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'subject_id' => 'required|exists:subjects,id',
                'score' => 'required|numeric|min:0|max:100',
            ]);

            $grade = SubjectGrade::updateOrCreate(
                ['subject_id' => $validatedData['subject_id'], 'user_id' => $validatedData['user_id']],
                ['grade' => $validatedData['score']]
            );

            return redirect()->back()->with('success', 'Grade saved successfully!');

        } else {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
        }
    }
}
