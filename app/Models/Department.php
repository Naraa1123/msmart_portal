<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolClass;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $guarded = [];


    public function entrants()
    {
        return $this->hasMany(Entrant::class, 'department_id', 'id');
    }
    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
