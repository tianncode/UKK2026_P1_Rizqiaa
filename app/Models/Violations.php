<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violations extends Model
{
    protected $table = 'violations';

    public $timestamps = false;

    protected $fillable = [
        'loan_id',
        'user_id',
        'return_id',
        'type',
        'points',
        'days_late',
        'description',
        'status',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi ke loans
    public function loan()
    {
        return $this->belongsTo(Loans::class, 'loan_id');
    }

    // Relasi ke users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke returns
    public function return()
    {
        return $this->belongsTo(Returns::class, 'return_id');
    }

    // Relasi ke settlements
    public function settlement()
    {
        return $this->hasOne(Settlements::class, 'violation_id');
    }
}
