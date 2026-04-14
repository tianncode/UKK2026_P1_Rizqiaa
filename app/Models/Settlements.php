<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlements extends Model
{
    protected $table = 'settlements';

    public $timestamps = false;

    protected $fillable = [
        'violation_id',
        'employee_id',
        'description',
        'settled_at',
    ];

    protected $casts = [
        'settled_at' => 'datetime',
    ];

    // Relasi ke violations
    public function violation()
    {
        return $this->belongsTo(Violations::class, 'violation_id');
    }

    // Relasi ke users (employee)
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
