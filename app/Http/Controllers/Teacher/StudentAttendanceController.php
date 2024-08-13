<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\ClassSubjectTopic;
use App\Models\IssuedStudent;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class StudentAttendanceController extends Controller
{
    public function showAttendanceReport(Request $request)
    {
        $teacher = Auth::user();

        if ($teacher->role_as == 2) {

            $classId = $request->input('class_id');
            $month = $request->input('month');
            $year = $request->input('year');

            if ($classId == null)
            {
                $classId = $teacher->teacherClasses->first();
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


            $classes = $teacher->teacherClasses;

            return view('teacher.attendance.report', compact('students', 'dates','classes','year','request'));
        } else {

            return redirect('teacher/dashboard')->with('message', 'Таньд багшийн хэсэг рүү нэвтрэх эрх байхгүй байна');
        }


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


    public function index(Request $request)
    {
        $teacher = Auth::user();
        $data['getClass'] = $teacher->teacherClasses;

        if (!empty($request->get('class_id'))) {
            $students = User::select('users.*')
                ->join('user_details', 'users.id', '=', 'user_details.user_id')
                ->where('users.class_id', $request->get('class_id'))
                ->where('users.role_as', 3)
                ->where('user_details.status', 'studying')
                ->get();
                

            $issuedStudentIds = IssuedStudent::pluck('user_id')->toArray();
            foreach ($students as $student) {
                $student->hasIssue = in_array($student->id, $issuedStudentIds);
            }

            $data['getStudent'] = $students;
        }

        $selectedClass = $request->get('class_id');
        if (!empty($selectedClass)) {
            $data['getObject'] = ClassSubject::where('class_id', $selectedClass)->get();
        } else {
            $data['getObject'] = null;
        }

        return view('teacher.attendance.index', compact('data'));
    }



    public function store(Request $request)
    {
        $attendance_date = $request->get('attendance_date', now()->format('Y-m-d'));

        $check_attendance = StudentAttendance::where('user_id', $request->user_id)
            ->where('class_id', $request->class_id)
            ->whereDate('attendance_date', $attendance_date)
            ->first();

        if ($check_attendance) {
            $attendance = $check_attendance;
        } else {
            $attendance = new StudentAttendance;
            $attendance->user_id = $request->user_id;
            $attendance->class_id = $request->class_id;
            $attendance->attendance_date = $attendance_date;
        }

        $attendance->attendance_type = $request->attendance_type;
        $attendance->save();

        return response()->json(['message' => 'Attendance Successfully Saved']);
    }







}
