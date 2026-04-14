<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    protected $table = 'tools';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'item_type',
        'max_penalty_points',
        'description',
        'code_slug',
        'photo_path',
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

    public function bundleItems()
    {
        return $this->hasMany(BundleTools::class, 'bundle_id');
    }

    public function bundleOf()
    {
        return $this->hasMany(BundleTools::class, 'tool_id');
    }

    public function loans()
    {
        return $this->hasMany(Loans::class);
    }

    /** Mengembalikan unit yang tersedia dalam rentang tanggal tertentu */
    public function availableUnits(string $borrowDate, string $returnDate)
    {
        // Kode unit yang sedang dipinjam pada rentang tanggal tersebut
        $busyCodes = Loans::where('tool_id', $this->id)
            ->conflictingDates($borrowDate, $returnDate)
            ->pluck('unit_code')
            ->toArray();

        return $this->units()
            ->where('status', 'available')
            ->whereNotIn('code', $busyCodes)
            ->get();
    }

    /** Foto URL atau null */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path && file_exists(public_path($this->photo_path))) {
            return asset($this->photo_path);
        }
        return null;
    }
}
