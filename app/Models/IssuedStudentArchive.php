<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedStudentArchive extends Model
{
    use HasFactory;
    protected $table = 'issued_students_archive';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function issuedStudentArchive()
    {
        return $this->hasMany(IssuedStudentArchive::class);
    }

}
