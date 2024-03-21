<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaAccount extends Model
{
    protected $fillable = ['company_id','facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url'];
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
