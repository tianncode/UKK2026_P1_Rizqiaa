<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appeals extends Model
{
    protected $table = 'appeals';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'reviewed_by',
        'reason',
        'status',
        'points_deducted',
        'admin_notes',
        'created_at',
        'reviewed_at',
    ];

    protected $casts = [
        'created_at'  => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
