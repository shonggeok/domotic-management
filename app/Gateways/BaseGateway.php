<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 07:52
 */

namespace App\Gateways;

class BaseGateway
{
    /**
     * @var mixed
     */
    private $interface;

    /**
     * @param mixed $interface
     */
    protected function setInterface($interface)
    {
        $this->interface = $interface;
    }

    /**
     * @return mixed $interface
     */
    protected function getInterface()
    {
        return $this->interface;
    }
}
