<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{

    use HasFactory;
    protected $table = 'classes';
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_classes', 'class_id', 'user_id');
    }

    public function teacherClasses()
    {
        return $this->hasMany(TeacherClass::class);
    }

    public function subjects()
    {
        return $this->hasMany(ClassSubject::class,'class_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'class_id','id');
    }

    public function classTimetables()
    {
        return $this->hasMany(ClassTimetable::class,'class_id');
    }


    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_classes', 'class_id', 'survey_id');
    }

}
