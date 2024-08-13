<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\ClassTimetable;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        $attendance_request = AttendanceRequest::orderBy('created_at', 'desc')->get();
        return view('admin.attendance_request.index', compact('attendance_request','classes'));
    }

    public function changeDecision($id, $decision)
    {
        $attendance_request = AttendanceRequest::findOrFail($id);

        $allowedStatus = ['зөвшөөрөгдсөн', 'зөвшөөрөгдөөгүй'];
        if (!in_array($decision, $allowedStatus)) {
            return redirect()->back()->with('message', 'Invalid status selected');
        }
        $attendance_request->update(['request_decision' => $decision]);

        //student attendance нэмэх хэсэг

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

        return redirect('admin/attendance-request')->with('message', 'Decision changed successfully');
    }

    public function destroy($id)
    {
        $attendance_request = AttendanceRequest::findOrFail($id);
        $attendance_request->delete();
        return redirect('admin/attendance-request')->with('message', 'Attendance Request Deleted Successfully');
    }
}
