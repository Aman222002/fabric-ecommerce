<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    protected $table = 'user_subscription';
    protected $fillable = [
        'plan_id',
        'user_id',
        'subscription_status',
        'start_date',
        'end_date',
        'next_plan_id',
        'subscription_id'
    ];
}
