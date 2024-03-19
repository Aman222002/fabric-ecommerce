<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    const USER_CV = "cv";
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gc_customer_id',
        'mandate_id',
        'mandate_status',
        'plan_id',
        'subscription_status',
        'payment_id',
        'upgrade_status',
        'upgrade_plan_id',
        'upgrade_plan_payment_id',
        'phone',
        'status',
        'user_image',
        'reset_token',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }
    public function address()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function experience()
    {
        return $this->hasMany(UserExperience::class);
    }
    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }
    public function additionalInformation()
    {
        return $this->hasOne(AdditionalInformation::class);
    }
    // Inside the User model (app/User.php)
    public function userAchievements()
    {
        return $this->hasMany(UserAchievement::class);
    }
    public function userProfile()
    {
        return $this->hasMany(UserProfile::class);
    }
    // public function profile()
    // {
    //     return $this->hasOne(UserProfile::class);
    // }
    public function skill()
    {
        return $this->hasOne(Skill::class);
    }
    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    public function permissionaccesses()
    {
        return $this->hasMany(Permissionaccess::class);
    }
}
