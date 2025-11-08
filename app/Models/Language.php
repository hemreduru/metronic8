<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * User settings relationship
     */
    public function userSettings(): HasMany
    {
        return $this->hasMany(UserSetting::class, 'preferred_language_id');
    }

    /**
     * Get active languages ordered by sort_order
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get default language (Turkish)
     */
    public static function getDefault()
    {
        return self::where('code', 'tr')->first() ?? self::first();
    }

    /**
     * Get language by code
     */
    public static function getByCode(string $code)
    {
        return self::where('code', $code)->first();
    }
}
