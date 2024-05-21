<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'type',
        'value',
        'expiry_date',
    ];

    public function getExpiryDateAttribute()
    {
        return Carbon::parse($this->attributes['expiry_date'])->format('Y-m-d');
    }
}
