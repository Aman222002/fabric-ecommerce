<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'company_email',
        'username',
        'password',
        'registration_number',
        'company_address',
        'phone_number',
        'description',
        'status',
    ];
}
