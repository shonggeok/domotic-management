<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 09:45
 */

namespace Tests\Feature\Commands;


use App\Console\Commands\UpdatePublicIP;
use App\Gateways\PublicIPGateway;
use App\Repositories\PublicIPRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ipify\Exception\ConnectionError;
use Ipify\Exception\ServiceError;
use Exception;
use Mockery;
use Tests\TestCase;

class PublicIPTest extends TestCase
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

    /**
     * Test command thrown generic exception
     */
    public function test_command_thrown_generic_exception()
    {
        //$this->withoutExceptionHandling();

        $previous_public_ip = '1.2.3.4';
        $current_public_ip = '5.6.7.8';

        $data = [
            'ip_address' => $previous_public_ip
        ];

        factory(PublicIPRepository::class)->create($data);

        $mock = Mockery::mock('Ipify\Ip');
        $mock->shouldReceive('get')
            ->andThrow(Exception::class)
            ->mock();

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($previous_public_ip,$record->ip_address);
        }

        $command = new UpdatePublicIP();
        $command->handle($mock);

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertNotEquals($current_public_ip,$record->ip_address);
        }
    }

    /**
     * Test command thrown service error
     */
    public function test_command_thrown_service_error()
    {
        //$this->withoutExceptionHandling();

        $previous_public_ip = '1.2.3.4';
        $current_public_ip = '5.6.7.8';

        $data = [
            'ip_address' => $previous_public_ip
        ];

        factory(PublicIPRepository::class)->create($data);

        $mock = Mockery::mock('Ipify\Ip');
        $mock->shouldReceive('get')
            ->andThrow(ServiceError::class)
            ->mock();

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($previous_public_ip,$record->ip_address);
        }

        $command = new UpdatePublicIP();
        $command->handle($mock);

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertNotEquals($current_public_ip,$record->ip_address);
        }
    }

    /**
     * Test command thrown connection error
     */
    public function test_command_thrown_connection_error()
    {
        //$this->withoutExceptionHandling();

        $previous_public_ip = '1.2.3.4';
        $current_public_ip = '5.6.7.8';

        $data = [
            'ip_address' => $previous_public_ip
        ];

        factory(PublicIPRepository::class)->create($data);

        $mock = Mockery::mock('Ipify\Ip');
        $mock->shouldReceive('get')
            ->andThrow(ConnectionError::class)
            ->mock();

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($previous_public_ip,$record->ip_address);
        }

        $command = new UpdatePublicIP();
        $command->handle($mock);

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertNotEquals($current_public_ip,$record->ip_address);
        }
    }

    /**
     * Test command can update public ip
     */
    public function test_command_can_update_public_ip()
    {
        $this->withoutExceptionHandling();

        $previous_public_ip = '1.2.3.4';
        $current_public_ip = '5.6.7.8';

        $data = [
            'ip_address' => $previous_public_ip
        ];

        factory(PublicIPRepository::class)->create($data);

        $mock = Mockery::mock('Ipify\Ip');
        $mock->shouldReceive('get')
            ->andReturn($current_public_ip)
            ->mock();

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($previous_public_ip,$record->ip_address);
        }

        $command = new UpdatePublicIP();
        $command->handle($mock);

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($current_public_ip,$record->ip_address);
        }
    }

    /**
     * Test command can create public ip
     */
    public function test_command_can_create_public_ip()
    {
        $this->withoutExceptionHandling();

        $current_public_ip = '5.6.7.8';

        $mock = Mockery::mock('Ipify\Ip');
        $mock->shouldReceive('get')
            ->andReturn($current_public_ip)
            ->mock();

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);

        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 0);

        $command = new UpdatePublicIP();
        $command->handle($mock);

        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $mock);
        $records = $gateway->getAllRecords();
        $this->assertTrue(count($records) === 1);
        foreach ($records as $record) {
            $this->assertEquals($current_public_ip,$record->ip_address);
        }
    }

}