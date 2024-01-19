<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = ['user_id', 'street_address', 'city', 'state', 'zip_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
