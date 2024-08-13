<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTimetable extends Model
{
    use HasFactory;

    protected $table = 'class_timetables';
    protected $guarded = [];

    public function week()
    {
        return $this->belongsTo(Week::class,'week_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

}
