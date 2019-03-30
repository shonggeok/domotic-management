<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GetUserSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::id();
        if (is_int($user_id)) {
            $gateway = app()->make('\App\Gateways\Settings\SettingsUserGateway');
            $user_settings = $gateway->getAllRecordsForAuthenticatedUser($user_id);
            $request->attributes->add([
                'user_settings' => $user_settings
            ]);
        }
        return $next($request);
    }
}
