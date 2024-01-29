<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use HasRoles;
    use HasApiTokens, HasFactory, Notifiable;
    const USER_CV = "cv";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',

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

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }
}
