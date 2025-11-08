<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetUserLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->determineLocale($request);

        // Set application locale
        App::setLocale($locale);

        // Store in session for non-authenticated users
        Session::put('locale', $locale);

        return $next($request);
    }

    /**
     * Determine the locale to use for the current request
     */
    private function determineLocale(Request $request): string
    {
        // 1. Check if user is authenticated and has language preference
        if (Auth::check() && Auth::user()->settings && Auth::user()->settings->language) {
            $userLocale = Auth::user()->settings->language->code;
            return $userLocale;
        }

        // 2. Check session for guest users or users without preference
        if (Session::has('locale')) {
            return Session::get('locale');
        }

        // 3. Check if language is being switched via request
        if ($request->has('lang') && in_array($request->get('lang'), ['tr', 'en'])) {
            return $request->get('lang');
        }

        // 4. Check browser Accept-Language header
        $acceptedLanguage = $request->getPreferredLanguage(['tr', 'en']);
        if ($acceptedLanguage) {
            return $acceptedLanguage;
        }

        // 5. Default to Turkish
        return 'tr';
    }
}
