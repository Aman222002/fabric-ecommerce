<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateCv extends Model
{
    protected $table = 'generate_cv';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'hobbies',
        'highest_education',
        'university',
        'starting_year',
        'passing_year',
        'skills',
        'address',
        'upload_image',
    ];
}
