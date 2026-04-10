<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolUnits extends Model
{
    protected $fillable = [
        'tool_id',
        'code',
        'status',
        'notes'
    ];

    public function tool()
    {
        return $this->belongsTo(Tools::class, 'tool_id');
    }

    public function conditions()
    {
        return $this->hasMany(UnitConditions::class, 'unit_code', 'code');
    }
}
