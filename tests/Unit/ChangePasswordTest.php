<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 27/03/2019
 * Time: 09:40
 */

namespace Tests\Unit;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test we can update password
     *
     * @returns void
     */
    public function test_can_update_password()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $data = [
            'old_password' => 'password',
            'new_password' => 'loremipsum',
            'new_password_confirmation' => 'loremipsum'
        ];

        $gateway = $this->app->make('App\Gateways\PasswordGateway');
        $update = $gateway->updatePassword($data, $user_id);
        $this->assertTrue($update);
    }

    /**
     * Test we cannot update password if old password is wrong
     *
     * @returns void
     */
    public function test_cannot_update_password_if_old_password_is_wrong()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $data = [
            'old_password' => 'password2',
            'new_password' => 'loremipsum',
            'new_password_confirmation' => 'loremipsum'
        ];

        $gateway = $this->app->make('App\Gateways\PasswordGateway');
        $update = $gateway->updatePassword($data, $user_id);
        $this->assertFalse($update);
    }

    /**
     * Test we cannot update password if validator fails
     *
     * @returns void
     */
    public function test_cannot_update_password_if_new_password_is_not_a_string()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $data = [
            'old_password' => 'password',
            'new_password' => 'lor',
            'new_password_confirmation' => null
        ];

        $gateway = $this->app->make('App\Gateways\PasswordGateway');
        $update = $gateway->updatePassword($data, $user_id);
        $this->assertTrue(is_array($update));
    }

    /**
     * Test we cannot update password if validator fails
     *
     * @returns void
     */
    public function test_cannot_update_password_if_new_password_is_too_short()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $data = [
            'old_password' => 'password',
            'new_password' => 'lor',
            'new_password_confirmation' => 'lor'
        ];

        $gateway = $this->app->make('App\Gateways\PasswordGateway');
        $update = $gateway->updatePassword($data, $user_id);
        $this->assertTrue(is_array($update));
    }

    /**
     * Test we cannot update password if validator fails
     *
     * @returns void
     */
    public function test_cannot_update_password_if_validator_fails()
    {
        $this->withoutExceptionHandling();
        $user_id = 1;
        $user_data = [
            'id' => $user_id
        ];
        factory(User::class)->create($user_data);

        $data = [
            'old_password' => 'password',
            'new_password' => 'loremipsum',
            'new_password_confirmation' => 'loremipsum2'
        ];

        $gateway = $this->app->make('App\Gateways\PasswordGateway');
        $update = $gateway->updatePassword($data, $user_id);
        $this->assertTrue(is_array($update));
    }

}