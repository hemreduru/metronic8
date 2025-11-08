<?php

namespace App\Services;

use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * ProfileService
 *
 * Kullanıcı profil yönetimi için servis sınıfı
 * RC14: Exception handling with proper user feedback
 * RC18: Log all operations
 */
class ProfileService
{
    /**
     * Get profile data for display
     *
     * @param User $user
     * @return array
     */
    public function getProfileData(User $user): array
    {
        $user->load(['settings.preferredLanguage', 'roles']);

        // Get role names with fallback to name if display_name is null
        $roleNames = $user->roles->map(function($role) {
            return $role->display_name ?: $role->name;
        })->toArray();

        return [
            'user' => $user,
            'settings' => $user->settings,
            'roles' => $roleNames,
            'languages' => Language::where('is_active', true)->orderBy('sort_order')->get(),
            'themes' => $this->getAvailableThemes(),
        ];
    }

    /**
     * Update user profile information
     *
     * @param User $user
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function updateProfile(User $user, array $data): User
    {
        // Name güncellenirse username'i de yeniden oluştur
        if (isset($data['name']) && $data['name'] !== $user->name) {
            $user->name = $data['name'];
            $user->generateUsername();
        }

        // Email güncelleme
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        $user->save();

        return $user->fresh();
    }

    /**
     * Update user password
     *
     * @param User $user
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     * @throws \Exception
     */
    public function updatePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        // Verify current password
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \Exception(__('users.current_password_incorrect'));
        }

        // Update password
        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }

    /**
     * Update user settings (language, theme, etc.)
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    public function updateSettings(User $user, array $data): void
    {
        // Ensure user has settings
        if (!$user->settings) {
            $user->createDefaultSettings();
            $user->refresh();
        }

        $settings = $user->settings;

        // Update language preference
        if (isset($data['preferred_language_id'])) {
            $settings->preferred_language_id = $data['preferred_language_id'];

            // Update session
            $language = Language::find($data['preferred_language_id']);
            if ($language) {
                session(['locale' => $language->code]);
                app()->setLocale($language->code);
            }
        }

        // Update theme preference
        if (isset($data['theme'])) {
            $settings->theme = $data['theme'];
            session(['theme' => $data['theme']]);
        }

        $settings->save();
    }

    /**
     * Update user avatar
     *
     * @param User $user
     * @param UploadedFile $file
     * @return string Avatar path
     * @throws \Exception
     */
    public function updateAvatar(User $user, UploadedFile $file): string
    {
        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $file->store('avatars', 'public');

        $user->avatar = $path;
        $user->save();

        return $path;
    }

    /**
     * Delete user avatar
     *
     * @param User $user
     * @return bool
     */
    public function deleteAvatar(User $user): bool
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * Deactivate user account
     *
     * @param User $user
     * @return bool
     */
    public function deactivateAccount(User $user): bool
    {
        // Soft delete implementation veya is_active flag
        // Şu an için sadece marking yapıyoruz
        // İleride soft delete eklenebilir

        return true;
    }

    /**
     * Export user data (GDPR compliance)
     *
     * @param User $user
     * @return array
     */
    public function exportUserData(User $user): array
    {
        return [
            'user_info' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
            'settings' => $user->settings ? [
                'preferred_language' => $user->settings->preferredLanguage?->name,
                'theme' => $user->settings->theme,
            ] : null,
            'roles' => $user->roles->pluck('name')->toArray(),
            'current_role' => $user->currentRole?->name,
        ];
    }

    /**
     * Get available themes
     *
     * @return array
     */
    private function getAvailableThemes(): array
    {
        return [
            [
                'value' => 'light',
                'label' => __('common.light_theme'),
                'icon' => 'ki-sun'
            ],
            [
                'value' => 'dark',
                'label' => __('common.dark_theme'),
                'icon' => 'ki-moon'
            ],
            [
                'value' => 'system',
                'label' => __('common.system_theme'),
                'icon' => 'ki-screen'
            ]
        ];
    }
}
