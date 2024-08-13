<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $guarded = [];

    public function classes()
    {
        return $this->hasMany(ClassSubject::class, 'subject_id');
    }
}
