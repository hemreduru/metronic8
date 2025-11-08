<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'email_verified_at',
        'avatar',
        'current_role_id',
        'settings_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Current active role relationship
     */
    public function currentRole()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'current_role_id');
    }

    /**
     * Get current role name
     */
    public function getCurrentRole()
    {
        return $this->currentRole ? $this->currentRole->name : null;
    }

    /**
     * Generate and set username from name
     */
    public function generateUsername()
    {
        $username = generateUsername($this->name);

        // Check if username exists and add number if needed
        $originalUsername = $username;
        $counter = 1;

        while (static::where('username', $username)->where('id', '!=', $this->id ?? 0)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        $this->username = $username;
        return $username;
    }

    /**
     * Set current role for the user
     */
    public function setCurrentRole($roleId)
    {
        // Kullanıcının bu role sahip olduğunu kontrol et
        if ($this->roles()->where('id', $roleId)->exists()) {
            $this->update(['current_role_id' => $roleId]);

            // Session'a permission'ları yükle
            $this->loadPermissionsToSession();

            return true;
        }

        return false;
    }

    /**
     * Get current role permissions and load to session
     */
    public function loadPermissionsToSession()
    {
        if ($this->currentRole) {
            // Retrieve permissions that belong to the current role explicitly
            $permissions = \Spatie\Permission\Models\Permission::whereHas('roles', function ($q) {
                $q->where('id', $this->current_role_id);
            })->pluck('name')->toArray();

            session(['user_permissions' => $permissions]);
            // Debug log to help trace permission loading during role selection
            Log::info('Loaded permissions for user', [
                'user_id' => $this->id,
                'current_role_id' => $this->current_role_id,
                'permissions' => $permissions,
            ]);
        }
    }

    /**
     * Check if user has permission (from session)
     */
    public function hasCurrentPermission($permission)
    {
        $permissions = session('user_permissions', []);
        return in_array($permission, $permissions);
    }

    /**
     * User settings relationship
     */
    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * Get user's preferred language
     */
    public function getPreferredLanguage()
    {
        if ($this->settings && $this->settings->preferredLanguage) {
            return $this->settings->preferredLanguage;
        }

        return Language::getDefault();
    }

    /**
     * Set user's preferred language
     */
    public function setPreferredLanguage($languageId)
    {
        if (!$this->settings) {
            $this->settings()->create([
                'preferred_language_id' => $languageId,
                'dark_mode' => false,
            ]);
        } else {
            $this->settings->update(['preferred_language_id' => $languageId]);
        }

        // Session'a dil ayarını kaydet
        $language = Language::find($languageId);
        if ($language) {
            session(['user_language' => $language->code]);
            app()->setLocale($language->code);
        }
    }

    /**
     * Load user language to session
     */
    public function loadLanguageToSession()
    {
        $language = $this->getPreferredLanguage();
        session(['user_language' => $language->code]);
        app()->setLocale($language->code);
    }

    /**
     * Create default settings for user
     */
    public function createDefaultSettings()
    {
        if (!$this->settings) {
            $defaultLanguage = Language::getDefault();
            $this->settings()->create([
                'preferred_language_id' => $defaultLanguage->id,
                'dark_mode' => false,
            ]);
        }
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    /**
     * Get avatar or default
     */
    public function getAvatarOrDefaultAttribute()
    {
        return $this->avatar_url ?: asset('media/avatars/blank.png');
    }

    /**
     * Check if user is verified
     */
    public function getIsVerifiedAttribute()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Get user status
     */
    public function getStatusAttribute()
    {
        return $this->is_verified ? 'Verified' : 'Unverified';
    }

    /**
     * Get user status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return $this->is_verified ? 'badge-light-success' : 'badge-light-warning';
    }

    public function hasMultipleRoles()
    {
        return $this->roles()->count() > 1;
    }
}
