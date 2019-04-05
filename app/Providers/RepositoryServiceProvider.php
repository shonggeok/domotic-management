<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 08:03
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\CloudflareInterface',
            'App\Repositories\CloudflareRepository'
        );

        $this->app->bind(
            'App\Interfaces\Settings\SettingsCloudflareInterface',
            'App\Repositories\Settings\SettingsCloudflareRepository'
        );

        $this->app->bind(
            'App\Interfaces\Settings\SettingsUserInterface',
            'App\Repositories\Settings\SettingsUserRepository'
        );

        $this->app->bind(
            'App\Interfaces\PasswordInterface',
            'App\Repositories\PasswordRepository'
        );

        $this->app->bind(
            'App\Interfaces\PublicIPInterface',
            'App\Repositories\PublicIPRepository'
        );
    }
}
