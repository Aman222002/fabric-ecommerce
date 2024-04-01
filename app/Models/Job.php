<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Job extends Model
{
    use HasFactory;
    use Sluggable;
    protected $table = 'post_jobs';
    // protected $primaryKey='id';
    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'category_id',
        'job_type_id',
        'vacancy',
        'salary',
        'location',
        'description',
        'qualifications',
        'experience',
        'company_website',
        'post_status',
        'skill_id',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
    public function jobskill()
    {
        return $this->belongsTo(Skill::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public static function getTotalPublishedJobs()
    {
        return static::where('post_status', 'published');
    }
}
