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
use Cloudflare\API\Endpoints\DNS;
use Cloudflare\API\Endpoints\Zones;

class CloudflareRepository extends BaseRepository implements CloudflareInterface
{

    /**
     * @param Zones $endpoint
     * @param $settings
     * @return string
     * @throws \Cloudflare\API\Endpoints\EndpointException
     */
    public function getZoneId(Zones $endpoint, $settings)
    {
        $domain = $settings->domain_list;
        $zones_list = $endpoint->getZoneID($domain);
        return $zones_list;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @return \stdClass
     */
    public function listRecords(DNS $endpoint, string $zone_id)
    {
        $dns = $endpoint->listRecords($zone_id);
        return $dns;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @param string $type
     * @param string $name
     * @param string $content
     * @return bool
     */
    public function addRecord(DNS $endpoint, string $zone_id, string $type, string $name, string $content)
    {
        $add = $endpoint->addRecord($zone_id, $type, $name, $content);
        return $add;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @param string $record_id
     * @param string $type
     * @param string $name
     * @param string $content
     * @return \stdClass
     */
    public function updateRecord(DNS $endpoint, string $zone_id, string $record_id, string $type, string $name, string $content)
    {
        $details = [
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'proxied' => true,
        ];
        $update = $endpoint->updateRecordDetails($zone_id, $record_id, $details);
        return $update;
    }

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
     * @return DNS
     */
    public function createDnsEndpoint(Guzzle $adapter)
    {
        $endpoint = new DNS($adapter);
        return $endpoint;
    }

    /**
     * @param Guzzle $adapter
     * @return Zones
     */
    public function createZonesEndpoint(Guzzle $adapter)
    {
        $endpoint = new Zones($adapter);
        return $endpoint;
    }
}
