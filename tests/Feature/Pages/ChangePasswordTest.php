<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 27/03/2019
 * Time: 09:06
 */

namespace Tests\Feature\Pages;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test cannot update password if new password is too weak
     *
     * @return void
     */
    public function test_cannot_update_password_if_new_password_is_too_weak()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $data = [
            'old_password' => 'password',
            'new_password' => 'lo',
            'new_password_confirmation' => 'lo',
        ];

        $response = $this->actingAs($user)->patch(Route('password_update'),$data);
        $response->assertSessionHas('errors');
        $response->assertStatus(302);
    }

    /**
     * Test cannot update password if new password doesn't match
     *
     * @return void
     */
    public function test_cannot_update_password_if_new_password_doesnt_match_confirmation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $data = [
            'old_password' => 'password',
            'new_password' => 'loremipsum',
            'new_password_confirmation' => 'loremipsum2',
        ];

        $response = $this->actingAs($user)->patch(Route('password_update'),$data);
        $response->assertSessionHas('errors');
        $response->assertStatus(302);
    }

    /**
     * Test cannot update password if old password is wrong
     *
     * @return void
     */
    public function test_cannot_update_password_if_old_password_is_wrong()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $data = [
            'old_password' => 'password2',
            'new_password' => 'loremipsum',
            'new_password_confirmation' => 'loremipsum',
        ];

        $response = $this->actingAs($user)->patch(Route('password_update'),$data);
        $this->assertFalse(is_array($response));
        $response->assertSessionHas('error');
        $response->assertStatus(302);
    }

    /**
     * Test can change password
     *
     * @return void
     */
    public function test_can_update_password()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $data = [
            'old_password' => 'password',
            'new_password' => 'loremipsum',
            'new_password_confirmation' => 'loremipsum',
        ];

        $response = $this->actingAs($user)->patch(Route('password_update'),$data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    /**
     * Test that logged user can view change password page
     *
     * @return void
     */
    public function test_logged_user_can_view_change_password_page()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $request = $this->actingAs($user)->get(Route('password_show'));
        $request->assertStatus(200);
        $request->assertViewIs('v200.pages.change-password');
    }

    /**
     * Test that not logged user is redirected to login page
     *
     * @return void
     */
    public function test_not_logged_user_redirected_to_login_page()
    {
        //$this->withoutExceptionHandling();
        $request = $this->get(Route('password_show'));
        $request->assertStatus(302);
        $request->assertRedirect(Route('login'));
    }

}