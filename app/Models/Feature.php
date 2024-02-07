<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $fillable = [
        'Search',
        'Mails',
        'Price',
        'Validity',
        'Post Job',
        'Duration of Job-Post',
        'Number of Job-Post',
    ];
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
