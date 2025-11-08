<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    /**
     * Switch theme (light, dark, system)
     */
    public function switch(Request $request): JsonResponse
    {
        $request->validate([
            'theme' => 'required|in:light,dark,system'
        ]);

        $theme = $request->input('theme');

        // Session'a kaydet
        session(['theme' => $theme]);

        // Eğer kullanıcı giriş yapmışsa, veritabanına da kaydet
        if (auth()->check()) {
            $user = auth()->user();

            // Eğer user_settings yoksa oluştur
            if (!$user->settings) {
                $user->settings()->create([
                    'preferred_language_id' => session('language_id', 1), // Default Turkish
                    'theme' => $theme
                ]);
                $user->load('settings');
                $user->update(['settings_id' => $user->settings->id]);
            } else {
                // Varsa güncelle
                $user->settings->update(['theme' => $theme]);
            }
        }

        // Server-side toastr kullan (AJAX interceptor ile çalışır!)
        return response()->json([
            'status' => 'success',
            'message' => __('auth.theme_switched_successfully')
        ]);
    }

    /**
     * Get current theme
     */
    public function current(): JsonResponse
    {
        $theme = 'system'; // Default
        if (session()->has('theme')) {
            $theme = session('theme');
        } else {
            $theme = auth()->user()->settings->theme;
        }

        return response()->json([
            'theme' => $theme
        ]);
    }

    /**
     * Get available themes
     */
    public function available(): JsonResponse
    {
        return response()->json([
            'themes' => [
                [
                    'value' => 'light',
                    'label' => __('Açık Tema'),
                    'icon' => 'ki-sun'
                ],
                [
                    'value' => 'dark',
                    'label' => __('Koyu Tema'),
                    'icon' => 'ki-moon'
                ],
                [
                    'value' => 'system',
                    'label' => __('Sistem'),
                    'icon' => 'ki-screen'
                ]
            ]
        ]);
    }
}
