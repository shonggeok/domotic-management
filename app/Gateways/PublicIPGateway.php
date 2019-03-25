<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 08:11
 */

namespace App\Gateways;

use App\Interfaces\PublicIPInterface;
use Illuminate\Support\Facades\Validator;
use Ipify\Exception\ConnectionError;
use Ipify\Exception\ServiceError;
use Ipify\Ip;
use Exception;

class PublicIPGateway extends BaseGateway
{
    /**
     * @var \Ipify\Ip;
     */
    private $ipify;

    /**
     * PublicIPGateway constructor.
     * @param PublicIPInterface $interface
     */
    public function __construct(PublicIPInterface $interface, Ip $ipify)
    {
        $this->setInterface($interface);
        $this->setIpify($ipify);
    }

    /**
     * @return true|string
     */
    public function updatePublicIp()
    {
        // Get current public ip
        try {
            $current_ip = $this->getIpify()->get();
            $data = [
                'ip_address' => $current_ip
            ];
            $this->createOrUpdate($data);
            return true;
        } catch (ConnectionError $e) {
            return $e->getMessage();
        } catch (ServiceError $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection $collection
     */
    public function getAllRecords()
    {
        $collection = $this->getInterface()->getAllRecords();
        return $collection;
    }

    /**
     * @param $data
     * @return array|true
     */
    public function createOrUpdate($data)
    {
        $rules = [
            'ip_address' => [
                'required',
                'string',
                'ip'
            ]
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            $data[ 'previous_ip_address' ] = null;
            // 1 - get last ip
            $records = $this->getAllRecords();
            if (count($records) === 1) {
                $data[ 'previous_ip_address' ] = $records[ 0 ]->ip_address;
            }
            $this->getInterface()->createOrUpdate($data);
            return true;
        }
    }

    /**
     * @return Ip
     */
    private function getIpify(): Ip
    {
        return $this->ipify;
    }

    /**
     * @param Ip $ipify
     */
    private function setIpify(Ip $ipify): void
    {
        $this->ipify = $ipify;
    }
}
