<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'loan_id',
        'employee_id',
        'return_date',
        'late_days',
        'notes',
    ];

    protected $casts = [
        'return_date' => 'date',
        'late_days' => 'integer',
    ];

    /**
     * Relasi ke Loan
     */
    public function loan()
    {
        return $this->belongsTo(Loans::class , 'loan_id');
    }

    /**
     * Relasi ke User (Employee)
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Relasi ke Unit Conditions
     */
    public function unitConditions()
    {
        return $this->hasMany(UnitConditions::class, 'return_id');
    }
}
