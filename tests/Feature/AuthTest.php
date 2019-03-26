<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 18:22
 */

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that logout destroy session object and redirect to login
     *
     * @return void
     */
    public function test_logout_destroy_session_redirect_to_login()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $check = Auth::check();
        $this->assertFalse($check);

        Auth::login($user);
        $check = Auth::check();
        $this->assertTrue($check);

        $response = $this->post(Route('logout'));
        $response->assertStatus(302);

        $check = Auth::check();
        $this->assertFalse($check);

        $response = $this->followingRedirects()->post(Route('logout'));
        $response->assertViewIs('v200.pages.login');

        $check = Auth::check();
        $this->assertFalse($check);
    }

    /**
     * Test that unsuccesfully submit redirect to login
     *
     * @return void
     */
    public function test_unsuccessfully_submit_redirect_login()
    {
        //$this->withoutExceptionHandling();
        factory(User::class)->create();
        $data = [
            'username' => 'admin',
            'password' => 'password_wrong'
        ];
        $response = $this->post(Route('login'),$data);
        $response->assertStatus(302);

        $response = $this->followingRedirects()->post(Route('login'),$data);
        $response->assertViewIs('v200.pages.login');
    }

    /**
     * Test that succesfull submit redirect to dashboard
     *
     * @return void
     */
    public function test_successfully_submit_redirect_dashboard()
    {
        $this->withoutExceptionHandling();
        factory(User::class)->create();
        $data = [
            'username' => 'admin',
            'password' => 'password'
        ];
        $response = $this->post(Route('login'),$data);
        $response->assertStatus(302);

        $response = $this->followingRedirects()->post(Route('login'),$data);
        $response->assertViewIs('v200.pages.dashboard');
    }

    /**
     * Test that not authenticated user is redirect to login
     *
     * @return void
     */
    public function test_not_authenticated_user_is_redirected_to_login()
    {
        $response = $this->get(Route('dashboard'));
        $response->assertStatus(302);
        $response->assertRedirect(Route('login'));

        $following = $this->followingRedirects()->get(Route('dashboard'));
        $following->assertViewIs('v200.pages.login');
    }

    /**
     * Test that route login returns login view
     *
     * @return void
     */
    public function test_login_route_returns_login_view()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(Route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('v200.pages.login');
    }

}