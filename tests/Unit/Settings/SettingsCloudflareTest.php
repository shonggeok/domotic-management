<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 07:55
 */

namespace Tests\Unit\Settings;


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
     * Test can read records
     *
     * @return void
     */
    public function test_can_read_record()
    {
        $this->withoutExceptionHandling();

        $user_id = 1;

        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $settings_data = [
            'user_id' => $user_id,
        ];
        factory(SettingsCloudflareRepository::class)->create($settings_data);
        $gateway = $this->app->make('\App\Gateways\Settings\SettingsCloudflareGateway');
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===1);


    }
}