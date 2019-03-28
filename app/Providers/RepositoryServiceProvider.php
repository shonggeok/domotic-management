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
            'App\Interfaces\PasswordInterface', // Interface
            'App\Repositories\PasswordRepository' // Eloquent
        );

        $this->app->bind(
            'App\Interfaces\PublicIPInterface', // Interface
            'App\Repositories\PublicIPRepository' // Eloquent
        );
    }
}
