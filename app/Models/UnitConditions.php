<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitConditions extends Model
{
    /**
     * Tabel tidak punya updated_at, hanya recorded_at sebagai timestamp pencatatan.
     */
    public $timestamps = false;

    protected $fillable = [
        'unit_code',
        'return_id',
        'conditions',
        'notes',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(ToolUnits::class, 'unit_code', 'code');
    }

    // /**
    //  * Kondisi ini terkait dengan return mana (opsional).
    //  */
    // public function return(): BelongsTo
    // {
    //     return $this->belongsTo(ToolReturn::class, 'return_id');
    // }
}
