<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use function Laravel\Prompts\alert;

class StudentAttendanceController extends Controller
{

    public function index(Request $request)
    {
        $data['getClass'] = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date')))
        {
            $data['getStudent'] = User::select('users.*')
                ->join('user_details', 'users.id', '=', 'user_details.user_id')
                ->where('users.class_id', $request->get('class_id'))
                ->where('users.role_as', 3)
                ->where('user_details.status', 'studying')
                ->get();
        }

        return view('admin.attendance.index', compact('data'));
    }

    public function fetch(Request $request)
    {
        $studentId = $request->input('student_id');
        $attendanceDate = $request->input('attendance_date');
        $data = StudentAttendance::where('user_id', $studentId)
            ->where('attendance_date', $attendanceDate)
            ->first();

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $check_attendance = StudentAttendance::CheckAlreadyAttendance($request->user_id, $request->class_id, $request->attendance_date);
        if (!empty($check_attendance))
        {
            $attendance = $check_attendance;
        }
        else
        {
            $attendance = new StudentAttendance;
            $attendance->user_id = $request->user_id;
            $attendance->class_id = $request->class_id;
            $attendance->attendance_date = $request->attendance_date;
        }
        $attendance->attendance_type = $request->attendance_type;

        $attendance->save();
    }


    public function showAttendanceReport(Request $request)
    {

        $classId = $request->input('class_id');
        $month = $request->input('month');
        $year = $request->input('year');

        if ($classId == null)
        {
            $classId = SchoolClass::where('status', '0')->first();
        }

        if ($year == null || $month == null)
        {
            $year = 2024;
            $month = 12;
        }


        $dates = $this->getDatesForMonth($year, $month);

        $students = User::where('class_id', $classId)
            ->whereHas('userDetails', function ($query) {
                $query->where('status', 'studying');
            })
            ->with(['userDetails', 'attendances' => function ($query) use ($month, $year) {
                $query->whereMonth('attendance_date', $month)
                    ->whereYear('attendance_date', $year);
            }])
            ->get();


        $classes = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.attendance.report', compact('students', 'dates','classes','year','request'));
    }

    private function getDatesForMonth($year, $month)
    {
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dates = [];
        for($i = 1; $i <= $numDays; $i++) {
            $dates[] = sprintf('%04d-%02d-%02d', $year, $month, $i);
        }
        return $dates;
    }

    public function comment(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|integer',
            'attendance_date' => 'required|date',
            'contact_status' => 'required',
            'comment' => 'nullable',
        ]);
        $attendance=StudentAttendance::where('user_id',$validatedData['student_id'])
            ->where('attendance_date',$validatedData['attendance_date'])
            ->first();
        $attendance->contact_status=$validatedData['contact_status'];
        if (!empty($validatedData['comment']))
        {
            $attendance->comment=$validatedData['comment'];
        }
        else
        {
            $attendance->comment=null;
        }

        $attendance->save();

        return redirect()->back()->with('success','Амжилттай нэмэгдлээ');
    }

}
