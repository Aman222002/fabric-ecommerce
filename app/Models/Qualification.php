<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'user_id',
        'education_type',
        'school_unversity',
        'starting_year',
        'passing_year',
        'highest_education_path',
        'still_pursuing'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
