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
}
