<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    use HasFactory;

    protected $table = 'teacher_classes';
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_classes', 'user_id', 'class_id');
    }


//    public function schoolClass()
//    {
//        return $this->belongsTo(SchoolClass::class, 'class_id');
//    }

}
