<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 07:55
 */

namespace Tests\Unit\Settings;


use App\Repositories\Settings\SettingsUserRepository;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingsUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test that a not valid option return false and it is not saved
     *
     * @return void
     */
    public function test_not_valid_option_return_false()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $option_key = 'never_will_be_valid';
        $option_value = 'never';
        $data = [
            'user_id' => $user_id,
            'option_key' => $option_key,
            'option_value' => $option_value
        ];

        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $status = $gateway->createOrUpdate($data,$user_id);
        $this->assertFalse($status);
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===0);
    }

    /**
     * Test can update settings if preset
     *
     * @return void
     */
    public function test_can_update_record()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $option_key = 'timezone';
        $option_value = 'Europe/Rome';
        $previous_data = [
            'user_id' => 1
        ];
        $data = [
            'user_id' => $user_id,
            $option_key => $option_value
        ];
        factory(SettingsUserRepository::class)->create($previous_data);
        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===1);
        $status = $gateway->createOrUpdate($data,$user_id);
        $this->assertTrue($status);
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===1);

    }

    /**
     * Test can insert settings if not present
     *
     * @return void
     */
    public function test_can_create_record_if_not_present()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $option_key = 'timezone';
        $option_value = 'Europe/Rome';
        $data = [
            'user_id' => $user_id,
            $option_key => $option_value
        ];

        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===0);
        $status = $gateway->createOrUpdate($data,$user_id);
        $this->assertTrue($status);
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===1);

    }

    /**
     * Test empty settings return false
     *
     * @return void
     */
    public function test_empty_settings_return_false()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $data = [];

        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $status = $gateway->createOrUpdate($data,$user_id);
        $this->assertFalse($status);

    }

    /**
     * Test empty table returns null
     *
     * @return void
     */
    public function test_empty_table_returns_null()
    {
        $this->withoutExceptionHandling();

        $user_id = 1;

        $user_data = [
            'id' => 1
        ];
        factory(User::class)->create($user_data);

        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===0);


    }

    /**
     * Test can read only records of authenticated users.
     *
     * @return void
     */
    public function test_can_read_only_records_of_authenticated_user()
    {
        $this->withoutExceptionHandling();

        // First user
        $first_user_id = 1;
        $first_user_data = [
            'id' => $first_user_id,
            'username' => $this->faker->userName
        ];
        factory(User::class)->create($first_user_data);

        // Second user
        $second_user_id = 2;
        $second_user_data = [
            'id' => $second_user_id,
            'username' => $this->faker->userName
        ];
        factory(User::class)->create($second_user_data);

        $option_key = 'timezone';
        $option_value = 'Europe/Rome';
        $data = [
            'user_id' => $second_user_id,
            'option_key' => $option_key,
            'option_value' => $option_value
        ];
        factory(SettingsUserRepository::class)->create($data);
        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $records = $gateway->getAllRecordsForAuthenticatedUser($first_user_id);
        $this->assertTrue(count($records)===0);

        $records = $gateway->getAllRecordsForAuthenticatedUser($second_user_id);
        $this->assertTrue(count($records)===1);
        foreach ($records as $record) {
            $this->assertTrue((int)$record->user_id === $second_user_id);
            $this->assertTrue($record->option_key === $option_key);
            $this->assertTrue($record->option_value === $option_value);
        }


    }

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
            'id' => 1
        ];
        factory(User::class)->create($user_data);

        $option_key = 'timezone';
        $option_value = 'Europe/Rome';
        $data = [
            'user_id' => $user_id,
            'option_key' => $option_key,
            'option_value' => $option_value
        ];
        factory(SettingsUserRepository::class)->create($data);
        $gateway = $this->app->make('\App\Gateways\Settings\SettingsUserGateway');
        $records = $gateway->getAllRecordsForAuthenticatedUser($user_id);
        $this->assertTrue(count($records)===1);
        foreach ($records as $record) {
            $this->assertTrue((int)$record->user_id === $user_id);
            $this->assertTrue($record->option_key === $option_key);
            $this->assertTrue($record->option_value === $option_value);
        }


    }
}