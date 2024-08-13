<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassTimetable;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
//        dd(array_values($user->class()->name));
        $login_user_class = $user->class->name;

        $login_user_dep =  $user->class->department->name;

        $class = SchoolClass::with('classTimetables.week')->where('name', $login_user_class)->first();

        $data = [];

        foreach ($class->classTimetables as $timetable) {
            $dayOfWeek = $timetable->week->id;
            $data[$timetable->name]['name'] = $login_user_class;
            $data[$timetable->name]['department'] = $login_user_dep;
            $data[$timetable->name]['week'][] = [
                'week_name' => $timetable->week->name,
                'fullcalendar_day' => $dayOfWeek,
                'start_time' => $timetable->start_time,
                'end_time' => $timetable->end_time,
                'room_number' => $timetable->room_number,
            ];
        }

        $result = array_values($data);

        return view('student.timetable', compact('result'));
    }

}
