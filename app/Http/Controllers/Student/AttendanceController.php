<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $student_attendance =  StudentAttendance::where('user_id', Auth::user()->id)->orderBy('attendance_date','ASC')->get();
        return view('student.attendance', compact('user','student_attendance'));
    }
}
