<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Language;
use App\Models\UserSetting;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:tr,en'
        ]);

        $langCode = $request->input('lang');
        $language = Language::where('code', $langCode)->first();

        if (!$language) {
            return back()->withErrors(['lang' => __('common.invalid_language')]);
        }

        // If user is authenticated, save preference to database
        if (Auth::check()) {
            $user = Auth::user();

            // Create or update user settings
            $settings = $user->settings ?: new UserSetting(['user_id' => $user->id]);
            $settings->preferred_language_id = $language->id;
            $settings->save();

            // Update user relationship if it's a new setting
            if (!$user->settings) {
                $user->settings_id = $settings->id;
                $user->save();
            }
        }

        // Always update session
        Session::put('locale', $langCode);

        return back()->with('success', __('common.language_switched'));
    }

    /**
     * Get available languages
     */
    public function available()
    {
        $languages = Language::active()->orderBy('sort_order')->get();

        return response()->json($languages);
    }

    /**
     * Get current language
     */
    public function current()
    {
        $currentLocale = app()->getLocale();
        $currentLanguage = Language::where('code', $currentLocale)->first();

        return response()->json($currentLanguage);
    }
}
