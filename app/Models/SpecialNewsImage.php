<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNewsImage extends Model
{
    use HasFactory;
    protected $table='special_news_images';
    protected $guarded = [];

    public function specialNews()
    {
        return $this->belongsTo(SpecialNews::class);
    }
}
