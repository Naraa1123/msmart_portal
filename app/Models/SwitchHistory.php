<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function fromClass()
    {
        return $this->belongsTo(SchoolClass::class, 'from_class_id', 'id');
    }

    public function toClass()
    {
        return $this->belongsTo(SchoolClass::class, 'to_class_id', 'id');
    }

}
