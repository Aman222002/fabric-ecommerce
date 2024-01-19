<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'certification_name',
        'company_name',
        'certificate_number',
        'expiry_date',
        'certificate_file_path',
    ];

    // Define a relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
