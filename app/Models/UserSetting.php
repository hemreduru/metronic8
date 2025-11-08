<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * UserSetting Model
 *
 * Manages user-specific application settings and preferences
 *
 * @property int $id
 * @property int $user_id Foreign key to users table
 * @property int|null $preferred_language_id Foreign key to languages table
 * @property bool $dark_mode Dark mode preference (deprecated, use theme)
 * @property string $theme Theme preference: 'light', 'dark', 'system'
 * @property array|null $additional_settings JSON field for extensible settings
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Language|null $preferredLanguage
 */
class UserSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'preferred_language_id',
        'dark_mode',
        'theme',
        'additional_settings',
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
        'additional_settings' => 'array',
    ];

    /**
     * User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Preferred language relationship
     */
    public function preferredLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'preferred_language_id');
    }
}
