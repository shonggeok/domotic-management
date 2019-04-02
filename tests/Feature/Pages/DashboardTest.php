<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 27/03/2019
 * Time: 07:56
 */

namespace Tests\Feature\Pages;


use App\Repositories\PublicIPRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test that dashboard has user_settings
     *
     * @return void
     */
    public function test_dashboard_has_user_settings()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->make();

        $public_ip = $this->faker->ipv4();
        $data = [
            'ip_address' => $public_ip
        ];
        factory(PublicIPRepository::class)->make($data);

        $response = $this->actingAs($user)->get(Route('dashboard'));
        $response->assertViewIs('v200.pages.dashboard');
        $response->assertViewHas('user_settings');
    }

    /**
     * Test that dashboard has last public ip
     *
     * @return void
     */
    public function test_dashboard_has_last_public_ip()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->make();

        $public_ip = $this->faker->ipv4();
        $data = [
            'ip_address' => $public_ip
        ];
        factory(PublicIPRepository::class)->make($data);

        $response = $this->actingAs($user)->get(Route('dashboard'));
        $response->assertViewIs('v200.pages.dashboard');
        $response->assertViewHas('public_ip');
    }
}