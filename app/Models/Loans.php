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

  const STATUS_PENDING   = 'pending';
  const STATUS_APPROVED  = 'approved';
  const STATUS_RETURNED  = 'returned';
  const STATUS_REJECTED  = 'rejected';
  const STATUS_CANCELLED = 'cancelled';

  protected $casts = [
    'loan_date' => 'date',
    'due_date' => 'date',
  ];

  protected static function booted(): void
  {
    static::creating(function (Loans $loan) {
      if (empty($loan->loan_code)) {
        // Format: LN-20240101-XXXX  (tanggal + 4 digit acak)
        $loan->loan_code = 'LN-'
          . now()->format('Ymd')
          . '-'
          . strtoupper(substr(uniqid(), -4));
      }
    });
  }

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

  // public function violations()
  // {
  //   return $this->hasMany(Violation::class);
  // }

  /**
   * Check if loan is overdue
   */
  public function isOverdue()
  {
    // 'borrowed' → 'approved'
    return $this->status === self::STATUS_APPROVED && $this->due_date < now();
  }

  /**
   * Get late days
   */
  public function getLateDaysAttribute()
  {
    // 'borrowed' → 'approved'
    if ($this->status === self::STATUS_APPROVED && $this->due_date < now()) {
      return now()->diffInDays($this->due_date);
    }
    return 0;
  }

  /** Hanya peminjaman yang sedang aktif / belum dikembalikan */
  public function scopeActive($query)
  {
    // Removed STATUS_ACTIVE — STATUS_APPROVED already represents active loans
    return $query->where('status', self::STATUS_APPROVED);
  }

  /** Filter berdasarkan rentang tanggal yang bentrok */
  public function scopeConflictingDates($query, string $borrowDate, string $returnDate)
  {
    // Removed STATUS_ACTIVE
    return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED])
      ->where(function ($q) use ($borrowDate, $returnDate) {
        $q->where('loan_date', '<=', $returnDate)
          ->where('due_date', '>=', $borrowDate);
      });
  }
}
