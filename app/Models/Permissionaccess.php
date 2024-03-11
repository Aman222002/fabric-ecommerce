<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissionaccess extends Model
{
    use HasFactory;
    protected $table ='permissionaccess'; 
    protected $fillable = [
        'user_id',
        'company_id',
        'permission_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
 
}
