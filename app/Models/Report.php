<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'description',
        'feedback',
        'student_id',
        'teacher_id',
        'status',
    ];

    // Define relationships if needed
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
