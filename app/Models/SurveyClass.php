<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyClass extends Model
{
    use HasFactory;

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
