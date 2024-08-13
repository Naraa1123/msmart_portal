<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\ClassTimetable;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($user->role_as == 2) {
            $teacherClasses = $user->teacherClasses;

            $data = [];

            foreach ($teacherClasses as $teacherClass) {
                $class = $teacherClass;

                foreach ($class->classTimetables as $timetable) {
                    $dayOfWeek = $timetable->week->id;
                    $uniqueKey = $timetable->id;
                    $data[$uniqueKey]['name'] = $class->name;
                    $data[$uniqueKey]['department'] = $class->department->name;
                    $data[$uniqueKey]['week'][] = [
                        'week_name' => $timetable->week->name,
                        'fullcalendar_day' => $dayOfWeek,
                        'start_time' => $timetable->start_time,
                        'end_time' => $timetable->end_time,
                        'room_number' => $timetable->room_number,
                    ];
                }
            }

            $result = array_values($data);


            return view('teacher.timetable', compact('result'));
        } else {
            return redirect('/');
        }
    }

    public function attendanceRequests()
    {
        $teacher = Auth::user();

        if ($teacher->role_as == 2) {
            // Get IDs of classes the teacher is in charge of
            $classIds = $teacher->teacherClasses()->pluck('class_id');


            // Get user IDs of students in these classes
            $studentIds = User::whereIn('class_id', $classIds)->pluck('id');

            // Get attendance requests made by these students
            $attendanceRequests = AttendanceRequest::whereIn('user_id', $studentIds)
                ->orderBy('created_at', 'desc')->get();

            return view('teacher.attendance_request',compact('attendanceRequests'));
        }
    }

    public function changeDecision($id, $decision)
    {
        $attendance_request = AttendanceRequest::findOrFail($id);

        $allowedStatus = ['зөвшөөрөгдсөн', 'зөвшөөрөгдөөгүй'];
        if (!in_array($decision, $allowedStatus)) {
            return redirect()->back()->with('message', 'Invalid status selected');
        }
        $attendance_request->update(['request_decision' => $decision]);

        $user_id=$attendance_request->user_id;
        $start_date=$attendance_request->request_start_date;
        $end_date=$attendance_request->request_end_date;
        $request_type=$attendance_request->request_type;

        $class_id = User::where('id', $user_id)->value('class_id');

        $start = Carbon::parse($start_date);

        $end = Carbon::parse($end_date);

        while ($start->lte($end)) {
            $daysOfWeek = $start->dayOfWeekIso;
            $dayDate = $start->toDateString();
            $lesson_days = ClassTimetable::where('class_id', $class_id)
                ->where('week_id', $daysOfWeek)
                ->get();

            if ($lesson_days->isNotEmpty()) {
                $checkexist = StudentAttendance::where('user_id', $user_id)
                    ->where('class_id', $class_id)
                    ->where('attendance_date', $dayDate)
                    ->first();
                if (!empty($checkexist)) {
                    $checkexist->attendance_type = ($decision == 'зөвшөөрөгдсөн') ? ($request_type == 'өвчтэй' ? 4 : 5) : 1;
                    $checkexist->update();
                } else {
                    $attendance = new StudentAttendance();
                    $attendance->class_id = $class_id;
                    $attendance->user_id = $user_id;
                    $attendance->attendance_date = $dayDate;
                    if ($decision == 'зөвшөөрөгдсөн') {
                        if ($request_type == 'өвчтэй') {
                            $attendance->attendance_type = 4;
                        } else if ($request_type == 'чөлөө') {
                            $attendance->attendance_type = 5;
                        }
                    } else {
                        $attendance->attendance_type = 1;
                    }
                    $attendance->save();
                }

            }

            $start->addDay();
        }

        return redirect('teacher/attendance-request')->with('message', 'Decision changed successfully');
    }



}
