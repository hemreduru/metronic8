<?php

namespace App\Policies;

use App\Models\User;

/**
 * UserPolicy
 *
 * Kullanıcı yetkilendirme politikası:
 * - Her kullanıcı sadece kendi profilini güncelleyebilir
 * - Software rolüne sahip kullanıcılar tüm kullanıcıları güncelleyebilir
 */
class UserPolicy
{
    /**
     * Determine if the user can view any users.
     * Software rolü tüm kullanıcıları görüntüleyebilir.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('software');
    }

    /**
     * Determine if the user can view the model.
     * Kullanıcı kendi profilini veya software rolü varsa diğer profilleri görüntüleyebilir.
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('software');
    }

    /**
     * Determine if the user can create users.
     * Sadece software rolü kullanıcı oluşturabilir.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('software');
    }

    /**
     * Determine if the user can update the model.
     * Kullanıcı kendi profilini veya software rolü varsa diğer profilleri güncelleyebilir.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('software');
    }

    /**
     * Determine if the user can delete the model.
     * Sadece software rolü kullanıcıları silebilir (kendi hesabı hariç).
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('software') && $user->id !== $model->id;
    }

    /**
     * Determine if the user can restore the model.
     * Sadece software rolü kullanıcıları geri yükleyebilir.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('software');
    }

    /**
     * Determine if the user can permanently delete the model.
     * Sadece software rolü kullanıcıları kalıcı olarak silebilir.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('software');
    }

    /**
     * Determine if the user can update settings.
     * Kullanıcı kendi ayarlarını veya software rolü varsa diğer ayarları güncelleyebilir.
     */
    public function updateSettings(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('software');
    }

    /**
     * Determine if the user can update password.
     * Kullanıcı kendi şifresini veya software rolü varsa diğer şifreleri güncelleyebilir.
     */
    public function updatePassword(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('software');
    }

    /**
     * Determine if the user can update avatar.
     * Kullanıcı kendi avatar'ını veya software rolü varsa diğer avatar'ları güncelleyebilir.
     */
    public function updateAvatar(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasRole('software');
    }
}
