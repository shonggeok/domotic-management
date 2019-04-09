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
     * Test can update record
     *
     * @returns void
     */
    public function test_can_update_record()
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
        $fixture = dirname(__DIR__,1).'/Fixtures/Cloudflare/Dns/update_record.json';
        $this->assertFileExists($fixture);
        $body = file_get_contents($fixture);
        $this->assertTrue(is_string($body));

        // Create body per as API
        $body = json_decode($body);

        $mock = Mockery::mock('Cloudflare\API\Endpoints\DNS');
        $mock->shouldReceive('updateRecordDetails')
            ->andReturn($body)
            ->mock();

        $zone_id = '023e105f4ecef8ad9ca31a8372d0c353';
        $record_id = '372e67954025e0ba6aaa6d586b9e0b59';
        $update_record = $gateway->updateRecord($mock, $zone_id, $record_id, 'A', $settings, '1.2.3.4');
        $this->assertEquals($record_id, $update_record->result->id);
    }

    /**
     * Test can create record
     *
     * @returns void
     */
    public function test_can_create_record()
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
        $fixture = dirname(__DIR__,1).'/Fixtures/Cloudflare/Dns/create_record.json';
        $this->assertFileExists($fixture);
        $body = file_get_contents($fixture);
        $this->assertTrue(is_string($body));

        // Create body per as API
        $body = json_decode($body);
        if (isset($body->result->id)) {
            $body = true;
        } else {
            $body = false;
        }

        $mock = Mockery::mock('Cloudflare\API\Endpoints\DNS');
        $mock->shouldReceive('addRecord')
            ->andReturn($body)
            ->mock();

        $zone_id = '023e105f4ecef8ad9ca31a8372d0c353';
        $add_record = $gateway->addRecord($mock, $zone_id, 'A', $settings, '1.2.3.4');
        $this->assertEquals($body, $add_record);
    }

    /**
     * Test we can get id of dns
     *
     * @return void
     */
    public function test_can_get_dns_id()
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

        $fixture = dirname(__DIR__,1).'/Fixtures/Cloudflare/Dns/list_record.json';
        $this->assertFileExists($fixture);
        $body = file_get_contents($fixture);
        $this->assertTrue(is_string($body));

        // Create body per as API
        $body = json_decode($body);
        $body = (object)['result' => $body->result, 'result_info' => $body->result_info];

        $mock = Mockery::mock('Cloudflare\API\Endpoints\DNS');
        $mock->shouldReceive('listRecords')
            ->andReturn($body)
            ->mock();

        $id = '372e67954025e0ba6aaa6d586b9e0b59';
        $zone_id = '023e105f4ecef8ad9ca31a8372d0c353';
        $id_dns = $gateway->getIdDns($mock, $zone_id, 'A');
        $this->assertEquals($id, $id_dns);


    }

    /**
     * Test we can get list record
     *
     * @return void
     */
    public function test_can_get_list_record()
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

        $fixture = dirname(__DIR__,1).'/Fixtures/Cloudflare/Dns/list_record.json';
        $this->assertFileExists($fixture);
        $body = file_get_contents($fixture);
        $this->assertTrue(is_string($body));

        // Create body per as API
        $body = json_decode($body);
        $body = (object)['result' => $body->result, 'result_info' => $body->result_info];

        $mock = Mockery::mock('Cloudflare\API\Endpoints\DNS');
        $mock->shouldReceive('listRecords')
            ->andReturn($body)
            ->mock();

        $zone_id = '023e105f4ecef8ad9ca31a8372d0c353';
        $list_record = $gateway->listRecords($mock, $zone_id);
        $this->assertEquals($body, $list_record);


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
     * Test we can create dns endpoint
     *
     * @return void
     */
    public function test_can_create_dns_endpoint()
    {
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $endpoint = $gateway->setDnsEndpoint($this->getAdapterMock());
        $this->assertInstanceOf('\Cloudflare\API\Endpoints\Dns',$endpoint);

    }

    /***
     * Test we can create zones endpoint
     *
     * @return void
     */
    public function test_can_create_zones_endpoint()
    {
        $gateway = $this->app->make('App\Gateways\CloudflareGateway');
        $endpoint = $gateway->setZonesEndpoint($this->getAdapterMock());
        $this->assertInstanceOf('\Cloudflare\API\Endpoints\Zones',$endpoint);

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