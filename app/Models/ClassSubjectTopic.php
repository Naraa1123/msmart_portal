<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTopic extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }
}
