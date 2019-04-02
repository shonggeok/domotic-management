<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    private $gateway;

    /**
     * @param $gateway
     */
    protected function setGateway($gateway)
    {
        $this->middleware('user-settings');
        $this->gateway = $gateway;
    }

    /**
     * @return string
     */
    protected function getGateway()
    {
        return $this->gateway;
    }
}
