<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'user_id',
        'company_id',
    ];
    public function job() {
        return $this->belongsTo(Job::class);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }

}
