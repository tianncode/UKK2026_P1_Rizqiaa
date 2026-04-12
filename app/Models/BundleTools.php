<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleTools extends Model
{
    protected $fillable = [
        'bundle_id',
        'tool_id',
        'qty',
    ];

    public function bundle()
    {
        return $this->belongsTo(Tools::class, 'bundle_id');
    }

    public function tool()
    {
        return $this->belongsTo(Tools::class, 'tool_id');
    }
}
