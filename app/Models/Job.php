<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table ='jobs';
    protected $fillable = [
        'title',
        'category_id',
        'job_type_id',
        'vacancy',
        'salary',
        'location',
        'description',
        'qualifications',
        'experience',
        'company_name',
        'company_location',
        'company_website',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

}
