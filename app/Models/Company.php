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
        'phone_number',
        'description',
        'status',
        'logo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id', 'id');
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
