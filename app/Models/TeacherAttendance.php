<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $table = 'teacher_attendances';
    protected $guarded = [];

    public function teacher()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'teacher_id');
    }

    public function class()
    {
        return $this->hasOne(SchoolClass::class, 'id', 'class_id');
    }
}
