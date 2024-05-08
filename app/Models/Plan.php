<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'duration',
        'price',
        'Posts_Allowed',
    ];
    protected $casts = [
        'price' => 'float',
    ];
   public function features()
    {
        return $this->hasOne(Feature::class, 'id', 'feature_id');
    }
}
