<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\TeacherClass;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherClassController extends Controller
{
    public function index()
    {
        $teacher_classes = TeacherClass::all();

        return view('admin.teacher_class.index', compact('teacher_classes'));
    }

    public function create()
    {
        $classes = SchoolClass::where('status', '0')
            ->orderBy('department_id')
            ->orderBy('name')
            ->get();

        $teachers = User::where('role_as', '2')->get();

        return view('admin.teacher_class.create', compact('classes', 'teachers'));

    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'classes' => 'required|array',
            'classes.*' => 'distinct',
        ]);

        $userId = $validatedData['user_id'];
        $classes = $validatedData['classes'];

        if (!empty($classes)) {
            if (count($classes) !== count(array_unique($classes))) {
                return redirect()->back()->with('message', 'Сонгогдсон ангиас аль хэдийн сонгогдсон анги байна');
            }

            foreach ($classes as $classId) {
                $existingRecord = TeacherClass::where('class_id', $classId)
                    ->exists();
                if (!$existingRecord) {
                    TeacherClass::create([
                        'user_id' => $userId,
                        'class_id' => $classId,
                    ]);
                } else {
                    return redirect()->back()->with('error', 'Ангиудаас аль нэг нь аль хэдийн өөр багштай холбоотой байна');
                }
            }
        } else {
            return redirect()->back()->with('message', 'Аль нэг ангийг сонгооорой');
        }

        return redirect('admin/teacher-classes')->with('message', 'TeacherClasses амжилттай холбогдлоо');
    }

    public function edit($id)
    {
        $decryptedId = decrypt($id);


        $teacherClass = TeacherClass::where('user_id',$decryptedId)->first();
        $teachers = User::where('role_as', '2')->get();

        $selectedClasses = SchoolClass::where('status', 0)
            ->whereIn('id', function ($query) use ($decryptedId) {
                $query->select('class_id')->from('teacher_classes')->where('user_id', $decryptedId);
            })
            ->get();


        $unselectedClasses = SchoolClass::where('status', 0)
            ->whereNotIn('id', function ($query) {
                $query->select('class_id')->from('teacher_classes');
            })
            ->get();


        return view('admin.teacher_class.edit', compact('teacherClass', 'teachers', 'selectedClasses', 'unselectedClasses'));
    }

    public function removeClass($teacherId, $classId)
    {
        $teacherClass = TeacherClass::where('user_id', $teacherId)->where('class_id', $classId)->first();

        if ($teacherClass) {
            $teacherClass->delete();

            return redirect()->back()->with('message', 'Class removed successfully');
        } else {
            return redirect()->back()->with('message', 'Class not found');
        }
    }

    public function addClass($teacherId, $classId)
    {
        $existingTeacherClass = TeacherClass::where('user_id', $teacherId)->where('class_id', $classId)->first();

        if (!$existingTeacherClass) {
            TeacherClass::create([
                'user_id' => $teacherId,
                'class_id' => $classId,
            ]);

            return redirect()->back()->with('message', 'Class added successfully');
        } else {
            return redirect()->back()->with('message', 'Teacher is already assigned to this class');
        }
    }


}
