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

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user');
    }
    public function firstWithExpiryDate($name, $userId)
    {
        return $this->whereName($name)->whereDoesntHave('users', fn($q) => $q->where('users.id', $userId))
        ->whereDate('expiry_date', '>=', Carbon::now())->first();
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'like', '%'.$keyword.'%');
    }
}
