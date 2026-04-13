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

    // Tambahkan method ini di Model User

    /**
     * Relasi ke Loans (sebagai employee)
     */
    public function loans()
    {
        return $this->hasMany(Loans::class, 'employee_id');
    }

    /**
     * Relasi ke Returns (sebagai employee)
     */
    public function returns()
    {
        return $this->hasMany(Returns::class, 'employee_id');
    }

    /**
     * Check if user is employee
     */
    public function isEmployee()
    {
        return $this->role === 'employee'; // Sesuaikan dengan sistem role Anda
    }
}
