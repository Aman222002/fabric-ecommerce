<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'duration',
        'price',
        'Posts_Allowed',
    ];
    public function features()
    {
        return $this->belongsTo(Feature::class,  'feature_id');
    }
}
