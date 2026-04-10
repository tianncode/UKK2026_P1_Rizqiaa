<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    protected $table = 'tools';

    protected $fillable = [
        'category_id',
        'name',
        'item_type',
        'max_penalty_points',
        'description',
        'code_slug',
        'photo_path'
    ];

    // relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function units()
    {
        return $this->hasMany(ToolUnits::class, 'tool_id');
    }
}
