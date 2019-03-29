<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 10:18
 */

namespace Tests\Feature;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsUserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test cannot update settings returns error
     *
     * @return void
     */
    public function test_cannot_update_settings_returns_error()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ] ;
        $user = factory(User::class)->create($user_data);

        $data = [
            'never_valid' => 'not_valid'
        ];
        $request = $this->actingAs($user)->patch(Route('settings_user_update'),$data);
        $request->assertStatus(302);
        $request->assertSessionHas('error');

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

        $data = [
            'timezone' => 'Europe/Rome'
        ];
        $request = $this->actingAs($user)->patch(Route('settings_user_update'),$data);
        $request->assertStatus(302);
        $request->assertSessionHas('success');

    }

    /**
     * Test settings page return settings for authenticated user
     *
     * @return void
     */
    public function test_settings_user_page_has_settings_user()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        $user = factory(User::class)->create($user_data);

        $request = $this->actingAs($user)->get(Route('settings_user'));
        $request->assertViewIs('v200.pages.settings-user');
        $request->assertViewHas('settings_user');
    }

    /**
     * Test that not logged user is redirected to login page
     *
     * @return void
     */
    public function test_not_logged_user_redirected_to_login_page()
    {
        //$this->withoutExceptionHandling();
        $request = $this->get(Route('settings_user'));
        $request->assertStatus(302);
        $request->assertRedirect(Route('login'));
    }


}