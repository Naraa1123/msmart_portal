<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNews extends Model
{
    use HasFactory;
    protected $table='special_news';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(SpecialNewsImage::class);
    }
}
