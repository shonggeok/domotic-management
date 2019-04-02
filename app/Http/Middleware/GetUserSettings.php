<?php

namespace App\Http\Middleware;

use App\Gateways\Settings\SettingsUserGateway;
use App\Repositories\Settings\SettingsUserRepository;
use Closure;
use Illuminate\Support\Facades\App;
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
            $interface = new SettingsUserRepository();
            $gateway = new SettingsUserGateway($interface);
            $user_settings = $gateway->getAllRecordsForAuthenticatedUser($user_id);
            $request->attributes->add([
                'user_settings' => $user_settings
            ]);
        }
        $language = 'en';
        if (isset($user_settings) && count($user_settings) > 0) {
            foreach ($user_settings as $setting) {
                if ($setting->option_key === 'language') {
                    $language = $setting->option_value;
                }
            }
        }
        App::setLocale($language);
        return $next($request);
    }
}
