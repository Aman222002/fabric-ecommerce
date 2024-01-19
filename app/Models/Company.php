<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'registration_number',
        'company_address',
        'phone_number',
        'description',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
