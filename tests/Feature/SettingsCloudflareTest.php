<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 10:18
 */

namespace Tests\Feature;


use App\Repositories\Settings\SettingsCloudflareRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingsCloudflareTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * Test cannot update if validator fails
     *
     * @return void
     */
    public function test_cannot_update_if_validator_fails()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ] ;
        $user = factory(User::class)->create($user_data);

        $settings_data = [
            'user_id' => $user_id,
        ];
        $request = $this->actingAs($user)->patch(Route('settings_cloudflare_update'),$settings_data);
        $request->assertStatus(302);
        $request->assertSessionHas('errors');

    }

    /**
     * Test can update settings returns success
     *
     * @return void
     */
    public function test_can_update_settings_returns_success()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ] ;
        $user = factory(User::class)->create($user_data);

        $settings_data = [
            'user_id' => $user_id,
            'api_key' => $this->faker->asciify('********'),
            'email' => $this->faker->email,
            'domain_list' => $this->faker->domainName
        ];
        $request = $this->actingAs($user)->patch(Route('settings_cloudflare_update'),$settings_data);
        $request->assertStatus(302);
        $request->assertSessionHas('success');

    }

    /**
     * Test settings page return settings for authenticated user
     *
     * @return void
     */
    public function test_settings_page_has_settings()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        $user = factory(User::class)->create($user_data);

        $request = $this->actingAs($user)->get(Route('settings_cloudflare'));
        $request->assertViewIs('v200.pages.settings-cloudflare');
        $request->assertViewHas('settings_cloudflare');
    }

    /**
     * Test that not logged user is redirected to login page
     *
     * @return void
     */
    public function test_not_logged_user_redirected_to_login_page()
    {
        //$this->withoutExceptionHandling();
        $request = $this->get(Route('settings_cloudflare'));
        $request->assertStatus(302);
        $request->assertRedirect(Route('login'));
    }


}