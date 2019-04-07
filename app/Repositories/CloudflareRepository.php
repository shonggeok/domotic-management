<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 05/04/2019
 * Time: 08:04
 */

namespace App\Repositories;

use App\Interfaces\CloudflareInterface;
use App\Repositories\Settings\SettingsCloudflareRepository;
use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Endpoints\Zones;

class CloudflareRepository extends BaseRepository implements CloudflareInterface
{

    /**
     * @param SettingsCloudflareRepository $settings
     * @return APIKey
     */
    public function createApiKey(SettingsCloudflareRepository $settings)
    {
        $key = new APIKey($settings->email, $settings->api_key);
        return $key;
    }

    /**
     * @param APIKey $api_key
     * @return Guzzle
     */
    public function createAdapter(APIKey $api_key)
    {
        $adapter = new Guzzle($api_key);
        return $adapter;
    }

    /**
     * @param Guzzle $adapter
     * @return Zones
     */
    public function createZonesEndpoint(Guzzle $adapter)
    {
        $zones_endpoint = new Zones($adapter);
        return $zones_endpoint;
    }

    /**
     * @param Zones $zones_endpoint
     * @param $settings
     * @return string
     * @throws \Cloudflare\API\Endpoints\EndpointException
     */
    public function getZoneId(Zones $zones_endpoint, $settings)
    {
        $domain = $settings->domain_list;
        $zones_list = $zones_endpoint->getZoneID($domain);
        return $zones_list;
    }
}
