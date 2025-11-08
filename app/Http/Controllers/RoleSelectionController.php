<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleSelectionController extends Controller
{
    /**
     * Show role selection page
     */
    public function show()
    {
        $user = auth()->user();
        $roles = $user->roles()->get();

        // Eğer kullanıcının sadece 1 rolü varsa otomatik seç
        if ($roles->count() === 1) {
            $user->setCurrentRole($roles->first()->id);
            return redirect()->route('dashboard');
        }

        // Eğer hiç rolü yoksa
        if ($roles->count() === 0) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Hesabınıza henüz bir rol atanmamıştır. Lütfen yöneticinizle iletişime geçiniz.');
        }

        return view('auth.role-select', compact('roles'));
    }

    /**
     * Set selected role
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = auth()->user();

        // Kullanıcının bu rolü olup olmadığını kontrol et
        if (!$user->roles()->where('id', $request->role_id)->exists()) {
            return redirect()->back()->with('error', 'Bu rolü seçmeye yetkiniz bulunmamaktadır.');
        }

        // Aktif rolü ayarla
        $user->setCurrentRole($request->role_id);

        // After setting the current role, ensure this role actually has permission for the dashboard
        $permission = 'dashboard';
        if ($user->hasCurrentPermission($permission)) {
            return redirect()->route('dashboard')->with('success', __('common.role_selected'));
        }

        // If the selected role doesn't have permission to access dashboard, unset success and show informative error
        return redirect()->route('role.select')
            ->with('error', __('common.role_no_permission'));
    }

    /**
     * Switch role (for already logged in users)
     */
    public function switch(Request $request): RedirectResponse
    {
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        $user = auth()->user();

        if ($user->setCurrentRole($request->role_id)) {
            return redirect()->route('dashboard')
                ->with('success', 'Rol değiştirildi.');
        }

        return back()->with('error', 'Seçilen role sahip değilsiniz.');
    }
}
