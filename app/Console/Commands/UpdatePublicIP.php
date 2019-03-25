<?php

namespace App\Console\Commands;

use App\Gateways\PublicIPGateway;
use App\Repositories\PublicIPRepository;
use Illuminate\Console\Command;
use Ipify\Ip;

class UpdatePublicIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publicip:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the public IP address of server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Ip $ipify)
    {
        $interface = new PublicIPRepository();
        $gateway = new PublicIPGateway($interface, $ipify);
        $gateway->updatePublicIp();
    }
}
