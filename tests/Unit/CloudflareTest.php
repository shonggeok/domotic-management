<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 05/04/2019
 * Time: 08:06
 */

namespace Tests\Unit;


use App\Repositories\Settings\SettingsCloudflareRepository;
use App\User;
use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Auth\APIKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class CloudflareTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * Tear down the mockery
     */
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function getApiKeyMock()
    {
        $api_key = new APIKey('info@example.com','123456789');
        return $api_key;
    }

    public function getAdapterMock()
    {
        $adapter_mock = new Guzzle($this->getApiKeyMock());
        return $adapter_mock;
    }

    /**
     * Test we can get zone ID
     *
     * @return void
     */
    public function test_can_get_zone_id()
    {
        $user_id = 1;
        $user_data = [
            'id' => $user_id,
        ];
        factory(User::class)->create($user_data);
        $key = '123456789';
        $email = 'info@example.com';
        $domain_list = 'example.com';
        $settings_data = [
            'user_id' => $user_id,
            'api_key' => $key,
            'email' => $email,
            'domain_list' => $domain_list
        ];
        factory(SettingsCloudflareRepository::class)->create($settings_data);
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $settings = $gateway->getUserData($user_id);

        $fixture = dirname(__DIR__,1).'/Fixtures/Cloudflare/Zones/zone_id.txt';
        $this->assertFileExists($fixture);
        $body = file_get_contents($fixture);
        $this->assertTrue(is_string($body));

        $mock = Mockery::mock('Cloudflare\API\Endpoints\Zones');
        $mock->shouldReceive('getZoneID')
            ->andReturn(trim($body))
            ->mock();

        $zones = $gateway->getZoneId($mock, $settings);
        $this->assertEquals('50a900371ff4ffb5b387f2c34beac272', $zones);


    }

    /***
     * Test we can create zones endpoint
     *
     * @return void
     */
    public function test_can_create_zones_endpoint()
    {
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $zones_endpoint = $gateway->setZonesEndpoint($this->getAdapterMock());
        $this->assertInstanceOf('\Cloudflare\API\Endpoints\Zones',$zones_endpoint);

    }


    /***
     * Test we can create adapter
     *
     * @return void
     */
    public function test_can_create_adapter()
    {
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $adapter = $gateway->setAdapter($this->getApiKeyMock());
        $this->assertInstanceOf('\Cloudflare\API\Adapter\Guzzle',$adapter);

    }

    /***
     * Test we can generate apikey
     *
     * @return void
     */
    public function test_can_create_api_key()
    {
        $user_id = 1;
        $user_data = [
            'id' => $user_id,
        ];
        factory(User::class)->create($user_data);
        $key = '123456789';
        $email = 'info@example.com';
        $domain_list = 'example.com';
        $settings_data = [
            'user_id' => $user_id,
            'api_key' => $key,
            'email' => $email,
            'domain_list' => $domain_list
        ];
        factory(SettingsCloudflareRepository::class)->create($settings_data);
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $settings = $gateway->getUserData($user_id);
        $this->assertTrue($settings->count()===1);
        $api_key = $gateway->setApiKey($settings);
        $this->assertInstanceOf('\Cloudflare\API\Auth\APIKey',$api_key);

    }

    /***
     * Test empty settings return null
     *
     * @return void
     */
    public function test_empty_user_settings_return_null()
    {
        $user_id = 1;
        $user_data = [
            'id' => $user_id,
        ];
        factory(User::class)->create($user_data);
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $settings = $gateway->getUserData($user_id);
        $this->assertNull($settings);

    }

    /***
     * Test we can get user data
     *
     * @return void
     */
    public function test_can_get_user_settings()
    {
        $user_id = 1;
        $user_data = [
            'id' => $user_id,
        ];
        factory(User::class)->create($user_data);
        $settings_data = [
            'user_id' => $user_id,
            'api_key' => '123456789',
            'email' => 'info@example.com',
            'domain_list' => 'example.com',
        ];
        factory(SettingsCloudflareRepository::class)->create($settings_data);
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $settings = $gateway->getUserData($user_id);
        $this->assertTrue($settings->count()===1);

    }

    /**
     * Test we can instantiate class
     */
    public function test_can_instantiate_gateway()
    {
        $this->withoutExceptionHandling();
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $this->assertInstanceOf('App\Gateways\CloudflareGateway',$gateway);
    }
}