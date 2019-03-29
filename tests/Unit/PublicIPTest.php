<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 08:09
 */

namespace Tests\Unit;


use App\Repositories\PublicIPRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicIPTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * Test we cannot read last record if not present
     *
     * @return void
     */
    public function test_can_read_last_record_if_not_present()
    {
        $this->withoutExceptionHandling();

        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $record = $gateway->getLastRecord();
        $this->assertNull($record);

    }

    /**
     * Test we can read last record if present
     *
     * @return void
     */
    public function test_can_read_last_record()
    {
        $this->withoutExceptionHandling();

        $ip_address = $this->faker->ipv4();
        $data = [
            'ip_address' => $ip_address
        ];
        factory(PublicIPRepository::class)->create($data);
        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $record = $gateway->getLastRecord();
        $this->assertTrue($record->count() === 1);

    }

    /**
     * Test cannot update data if validator fails
     *
     * @return void
     */
    public function test_cannot_update_data_if_validator_fails()
    {
        $this->withoutExceptionHandling();
        factory(PublicIPRepository::class)->create();
        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);

        $public_ip = $this->faker->ipv4();
        $data = [
            'ip_address' => $public_ip,
        ];
        $update = $gateway->createOrUpdate($data);
        $this->assertTrue($update);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($public_ip,$record->ip_address);
        }

    }

    /**
     * Test can update data
     *
     * @return void
     */
    public function test_can_update_data()
    {
        $this->withoutExceptionHandling();
        factory(PublicIPRepository::class)->create();
        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);

        $public_ip = false;
        $data = [
            'ip_address' => $public_ip,
        ];
        $update = $gateway->createOrUpdate($data);
        $this->assertTrue(is_array($update));

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertNotEquals($public_ip,$record->ip_address);
        }

    }

    /**
     * Test cannot save data if ip_address validator fails
     *
     * @return void
     */
    public function test_cannot_save_data_if_ip_address_validator_fails()
    {
        $this->withoutExceptionHandling();
        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 0);

        $public_ip = false;
        $data = [
            'ip_address' => $public_ip,
        ];
        $update = $gateway->createOrUpdate($data);
        $this->assertTrue(is_array($update));

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 0);

    }

    /**
     * Test can save data if no records exist
     *
     * @return void
     */
    public function test_can_save_data_if_no_records_exist()
    {
        $this->withoutExceptionHandling();
        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 0);

        $public_ip = $this->faker->ipv4();
        $data = [
            'ip_address' => $public_ip,
        ];
        $update = $gateway->createOrUpdate($data);
        $this->assertTrue($update);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($public_ip,$record->ip_address);
        }

    }

    /**
     * Test can instantiate class
     *
     * @return void
     */
    public function test_can_instantiate_class()
    {
        $this->withoutExceptionHandling();
        $gateway = $this->app->make('App\Gateways\PublicIPGateway');
        $this->assertInstanceOf('App\Gateways\PublicIPGateway',$gateway);
    }

}