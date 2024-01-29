<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
       'first_line_address',
       'street',
       'city',
       'state',
       'postal_code',
       'company_id'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
   
}
