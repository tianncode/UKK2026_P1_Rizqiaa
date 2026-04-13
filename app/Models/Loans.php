<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'tool_id',
    'unit_code',
    'loan_code',
    'employee_id',
    'status',
    'loan_date',
    'due_date',
    'purpose',
    'notes',
  ];

  protected $casts = [
    'loan_date' => 'date',
    'due_date' => 'date',
  ];

  /**
   * Relasi ke User (Peminjam)
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * Relasi ke Tool
   */
  public function tool()
  {
    return $this->belongsTo(Tools::class, 'tool_id');
  }

  /**
   * Relasi ke Unit
   */
  public function unit()
  {
    return $this->belongsTo(ToolUnits::class, 'unit_code', 'code');
  }

  /**
   * Relasi ke Employee (yang memproses)
   */
  public function employee()
  {
    return $this->belongsTo(User::class, 'employee_id');
  }

  /**
   * Relasi ke Return
   */
  public function return()
  {
    return $this->hasOne(Returns::class);
  }

  /**
   * Check if loan is overdue
   */
  public function isOverdue()
  {
    return $this->status === 'borrowed' && $this->due_date < now();
  }

  /**
   * Get late days
   */
  public function getLateDaysAttribute()
  {
    if ($this->status === 'borrowed' && $this->due_date < now()) {
      return now()->diffInDays($this->due_date);
    }
    return 0;
  }
}
