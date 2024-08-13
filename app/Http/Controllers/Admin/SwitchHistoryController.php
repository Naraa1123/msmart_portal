<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\SwitchHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SwitchHistoryController extends Controller
{
    public function index()
    {
        $switch_history = SwitchHistory::orderBy('created_at', 'desc')->get();
        return view('admin.switch_history.index',compact('switch_history'));
    }

    public function attendance($id)
    {
        $decryptedId=decrypt($id);
        $user = User::findOrFail($decryptedId);
        $student_attendance =  StudentAttendance::where('user_id', $decryptedId)->orderBy('attendance_date','ASC')->get();
        return view('admin.switch_history.attandance_information', compact('user','student_attendance'));
    }
}
