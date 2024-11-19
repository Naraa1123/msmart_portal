<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\TeacherClass;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClassSubjectController extends Controller
{
    public function index()
    {
        $class_subjects = ClassSubject::orderBy("created_at", 'DESC')->get();
        $teacher_detail = [];
        foreach ($class_subjects as $cs) {
            $teacher_class = TeacherClass::where('class_id', $cs->class_id)->first();
            if ($teacher_class) {
                $teacher = UserDetail::where('user_id', $teacher_class->user_id)->first();
                if ($teacher) {
                    // Append teacher details to the $teacher_detail array
                    $teacher_detail[] = [
                        'class_id' => $teacher_class->class_id,
                        'name' => $teacher->firstname,
                    ];
                }
            }
        }
        $departments = Department::all();
        return view('admin.class_subject.index',compact('class_subjects','teacher_detail','departments'));
    }

    public function create()
    {
        $departments = ['Программ хангамж', 'График дизайн', 'Интерьер дизайн', 'Хүүхдийн анги','Ерөнхий судлах хичээл'];
        $subjectsByDepartment = [];

        // Fetch subjects grouped by department
        foreach ($departments as $department) {
            $subjectsByDepartment[$department] = Subject::where('department', $department)->get();
        }

        $classes = SchoolClass::where('status', '0')
            ->get()
            ->reject(function($class) {
                return $class->subjects->isNotEmpty();
            })
            ->sortBy(function($class) {
                return substr($class->name, 0, 2);
            });

        return view('admin.class_subject.create', compact('subjectsByDepartment', 'classes'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'class_id' => 'required|integer',
            'subjects' => 'required|array',
            'status' => 'nullable',
        ]);

        $classId = $validatedData['class_id'];
        $subjects = $validatedData['subjects'];

        if (!empty($subjects)) {
            foreach ($subjects as $subjectId) {

                $existingRecord = ClassSubject::where('class_id', $classId)
                    ->where('subject_id', $subjectId)
                    ->first();

                if (!$existingRecord) {
                    ClassSubject::create([
                        'class_id' => $classId,
                        'subject_id' => $subjectId,
                        'status' => $request->status == true ? '1' : '0',
                    ]);
                }
            }
        } else {
            return redirect()->back()->with('error', 'Хичээл сонгогдоогүй байна');
        }

        return redirect('admin/class-subjects')->with('success', 'Амжилттай');
    }


    public function edit($classId)
    {
        $decryptedClassId = decrypt($classId);

        $selectedSubjects = ClassSubject::where('class_id', $decryptedClassId)->get();

        if ($selectedSubjects->isEmpty()) {
            return redirect()->back()->with('error', 'No subjects selected for this class.');
        }

        $unselectedSubjects = Subject::whereNotIn('id', $selectedSubjects->pluck('subject_id'))
            ->where('status', '0')
            ->get()
            ->groupBy('department');

        $class_id = $decryptedClassId;
        $classes = SchoolClass::where('status',0)->get();

        return view('admin.class_subject.edit', compact('selectedSubjects', 'unselectedSubjects', 'class_id', 'classes'));
    }


    public function addAction($classId, $subjectId)
    {
        $classSubject = ClassSubject::where('class_id', $classId)->where('subject_id', $subjectId)->first();

        if (!$classSubject) {
            ClassSubject::create([
                'class_id' => $classId,
                'subject_id' => $subjectId,
                'status' => '0',
            ]);
        }

        return redirect()->route('admin.class-subject.edit', encrypt($classId))->with('success', 'Амжилттай нэмэгдлээ');
    }

    public function toggleStatus($classId, $subjectId)
    {
        $classSubject = ClassSubject::where('class_id', $classId)->where('subject_id', $subjectId)->first();

        if ($classSubject) {
            $classSubject->status = $classSubject->status === '0' ? '1' : '0';
            $classSubject->save();
        }

        return redirect()->route('admin.class-subject.edit', $classId)->with('success', 'Subject status updated successfully');
    }



    public function removeAction($classId, $subjectId)
    {
        $classSubject = ClassSubject::where('class_id', $classId)->where('subject_id', $subjectId)->first();

        if ($classSubject) {
            $classSubject->delete();
        }

        return redirect()->route('admin.class-subject.edit', encrypt($classId))->with('success', 'Subject removed from the class successfully');
    }


    public function destroy()
    {

    }

}
