<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $classes = SchoolClass::orderBy("created_at", 'desc')->get();

        return view('admin.class.index', compact('classes','departments'));
    }

    public function create()
    {
        $deps = Department::all();
        return view('admin.class.create', compact('deps'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'class_started_date' => 'required|date_format:Y-m-d',
            'department_id' => 'required|integer',
            'status' => 'nullable',
        ]);
        $date = $validatedData['class_started_date'];
        $datetime = Carbon::parse($date);

        $year = $datetime->format('y');
        $month = $datetime->format('m');

        $department = Department::find($validatedData['department_id']);
        $abbreviation = $department->abbreviation;

        $existingClassesCount = SchoolClass::where('department_id', $department->id)
            ->whereYear('class_started_date', $year)
            ->whereMonth('class_started_date', $month)
            ->count();

        $classNum = $existingClassesCount + 1;
        $className = $abbreviation . $year . $month . str_pad($classNum, 2, '0', STR_PAD_LEFT);

        while (SchoolClass::where('name', $className)->exists()) {
            $classNum++;
            $className = $abbreviation . $year . $month . str_pad($classNum, 2, '0', STR_PAD_LEFT);
        }

        SchoolClass::create([
            'name' => $className,
            'department_id' => $validatedData['department_id'],
            'class_started_date' => $validatedData['class_started_date'],
            'status' => $request->status == true ? '1' : '0',
        ]);

        return redirect('admin/class')->with('message', 'Анги амжилттай бүртгэгдлээ');
    }

    public function edit($id)
    {
        $decryptedId = decrypt($id);

        $deps = Department::orderBy('name', 'asc')->get();
        $class = SchoolClass::findOrFail($decryptedId);
        return view('admin.class.edit', compact('class','deps'));
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'class_started_date' => 'required|date_format:Y-m-d',
            'department_id' => 'required|integer',
            'status' => 'nullable',
        ]);

        $class = SchoolClass::findOrFail($id);

        if(!empty($validatedData['status']) && $validatedData['status']!=$class->status){
            $students=User::where('class_id',$class->id)
                ->whereHas('userDetails', function ($query) {
                $query->where('status', 'studying');
            })->get();

            foreach ($students as $student) {
                $userDetail = $student->userDetails()->first();

                if ($userDetail) {
                    $userDetail->status = 'graduated';
                    $userDetail->save();
                }
            }

        }

        $class->update([
            'department_id' => $validatedData['department_id'],
            'class_started_date' => $validatedData['class_started_date'],
            'status' => $request->status == true ? '1' : '0',
        ]);

        return redirect('admin/class')->with('success', 'Амжилттай шинэчлэгдлээ');
    }

    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $class = SchoolClass::findOrFail($decryptedId);
        $class->delete();
        return redirect('admin/class')->with('success', 'Амжилттай устгагдлаа');
    }

    public function students($id)
    {
        $decryptedId = decrypt($id);
        $students = User::where('class_id', $decryptedId)
            ->where('role_as', 3)
            ->get();

        $class=SchoolClass::where('id', $decryptedId)->first();
        $departmetId=$class->department_id;

        if($departmetId==1||$departmetId==3||$departmetId==5||$departmetId==8||$departmetId==12){
            if($students->count()>0){
                return view('admin.class.student',compact('students'));
            }
            else{
                return redirect()->back()->with('error','Сурагч олдсонгүй!');
            }
        }
        else{
            if($students->count()>0){
                return view('admin.class.certificate_student',compact('students'));
            }
            else{
                return redirect()->back()->with('error','Сурагч олдсонгүй!');
            }
        }




    }
}
