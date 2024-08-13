<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $table = 'student_attendances';
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    static public function CheckAlreadyAttendance($user_id, $class_id, $attendance_date)
    {
        return StudentAttendance::where('user_id', '=', $user_id)->where('class_id', '=', $class_id)->
            where('attendance_date', '=', $attendance_date)->first();
    }

}
