<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grading_topic_id',
        'grade',
    ];

    /**
     * Define a relationship to the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a relationship to the GradingTopic model.
     */
    public function gradingTopic()
    {
        return $this->belongsTo(GradingTopic::class);
    }
}
