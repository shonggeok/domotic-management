<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 31/03/2019
 * Time: 18:58
 */

namespace Tests\Feature\Middleware;


use App\Repositories\Settings\SettingsUserRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserSettingsMiddlewareTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test that middleware has language user settings
     *
     * @return void
     */
    public function test_middleware_settings()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => 1
        ];
        $user = factory(User::class)->create($user_data);

        $settings_data = [
            'user_id' => $user_id,
            'option_key' => 'language',
            'option_value' => 'it'
        ];

        factory(SettingsUserRepository::class)->create($settings_data);

        $response = $this->actingAs($user)->get(Route('dashboard'));
        $response->assertViewIs('v200.pages.dashboard');
        $response->assertViewHas('user_settings');
        $language = \App::getLocale();
        $this->assertTrue($language === 'it');
    }

}