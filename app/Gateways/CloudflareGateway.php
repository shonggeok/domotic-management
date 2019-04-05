<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 05/04/2019
 * Time: 08:08
 */

namespace App\Gateways;

use App\Gateways\Settings\SettingsCloudflareGateway;
use App\Interfaces\CloudflareInterface;
use App\Repositories\Settings\SettingsCloudflareRepository;
use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Endpoints\Zones;

class CloudflareGateway extends BaseGateway
{
    /**
     * CloudflareGateway constructor.
     * @param CloudflareInterface $interface
     */
    public function __construct(CloudflareInterface $interface)
    {
        $this->setInterface($interface);
    }

    /**
     * @param int $user_id
     * @return mixed|null
     */
    public function getUserData(int $user_id)
    {
        $interface = new SettingsCloudflareRepository();
        $settings_gateway = new SettingsCloudflareGateway($interface);
        $settings = $settings_gateway->getAllRecordsForAuthenticatedUser($user_id);
        if (isset($settings[ 0 ])) {
            return $settings[ 0 ];
        }
        return null;
    }

    /**
     * @param SettingsCloudflareRepository $settings
     * @return mixed
     */
    public function setApiKey(SettingsCloudflareRepository $settings)
    {
        $api_key = $this->getInterface()->createApiKey($settings);
        return $api_key;
    }

    /**
     * @param APIKey $api_key
     * @return mixed
     */
    public function setAdapter(APIKey $api_key)
    {
        $adapter = $this->getInterface()->createAdapter($api_key);
        return $adapter;
    }

    /**
     * @param Guzzle $adapter
     * @return mixed
     */
    public function setZonesEndpoint(Guzzle $adapter)
    {
        $zones_endpoint = $this->getInterface()->createZonesEndpoint($adapter);
        return $zones_endpoint;
    }

    /**
     * @param Zones $zones_endpoint
     * @param $settings
     * @return mixed
     */
    public function getZoneId(Zones $zones_endpoint, $settings)
    {
        $zone_id = $this->getInterface()->getZoneId($zones_endpoint, $settings);
        return $zone_id;
    }
}
