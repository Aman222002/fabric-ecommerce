<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;
    protected $table ='job_application';
    protected $fillable = [
        'job_id',
        'user_id',
        'company_id'
    ];
    public function job() {
        return $this->belongsTo(Job::class);
    }
}
