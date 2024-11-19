<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'department',
        'status',
    ];

    /**
     * Define a relationship to the Department model.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'grading_topic_id');
    }

    public function grades()
    {
        return $this->hasMany(TopicGrade::class, 'grading_topic_id');
    }
}
