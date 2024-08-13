<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'survey_classes', 'survey_id', 'class_id');
    }

    public function respondents()
    {
        return $this->hasMany(SurveyRespondents::class);
    }

}
