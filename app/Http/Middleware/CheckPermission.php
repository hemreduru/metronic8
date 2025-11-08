<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = null): Response
    {
        // Eğer permission belirtilmemişse route name'i kullan
        if (!$permission) {
            $permission = $request->route()->getName();
        }

        // Kullanıcı giriş yapmış mı kontrol et
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Kullanıcının aktif rolü var mı kontrol et
        if (!$user->current_role_id) {
            // avoid overriding existing flash messages
            if (!session()->has('error') && !session()->has('success')) {
                return redirect()->route('role.select')
                    ->with('error', __('common.please_select_role'));
            }

            return redirect()->route('role.select');
        }

        // Permission kontrolü
        if (!$user->hasCurrentPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => __('common.no_permission')], 403);
            }

            // avoid overriding existing flash messages
            if (!session()->has('error') && !session()->has('success')) {
                return redirect()->route('role.select')
                    ->with('error', __('common.no_permission'));
            }

            return redirect()->route('role.select');
        }

        return $next($request);
    }
}
