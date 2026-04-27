<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
        'penalty_points',
        'is_restricted'
    ];

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function loans()
    {
        return $this->hasMany(Loans::class, 'employee_id');
    }

    public function returns()
    {
        return $this->hasMany(Returns::class, 'employee_id');
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function violations()
    {
        return $this->hasMany(Violations::class, 'user_id');
    }
}
