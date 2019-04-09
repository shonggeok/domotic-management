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
use Cloudflare\API\Endpoints\DNS;
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
     * REAL API CALL
     */

    /**
     * @param Zones $zones_endpoint
     * @param $settings
     * @return mixed|string the unique zone id
     */
    public function getZoneId(Zones $zones_endpoint, $settings)
    {
        $zone_id = $this->getInterface()->getZoneId($zones_endpoint, $settings);
        return $zone_id;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @return mixed
     */
    public function listRecords(DNS $endpoint, string $zone_id)
    {
        $dns_list = $this->getInterface()->listRecords($endpoint, $zone_id);
        return $dns_list;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @param string $type_dns
     * @param SettingsCloudflareRepository $settings
     * @param string $content
     * @return mixed
     */
    public function addRecord(DNS $endpoint, string $zone_id, string $type_dns, SettingsCloudflareRepository $settings, string $content)
    {
        $domain = $settings->domain_list;
        $result = $this->getInterface()->addRecord($endpoint, $zone_id, $type_dns, $domain, $content);
        return $result;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @param string $record_id
     * @param string $type_dns
     * @param SettingsCloudflareRepository $settings
     * @param string $content
     * @return mixed
     */
    public function updateRecord(DNS $endpoint, string $zone_id, string $record_id, string $type_dns, SettingsCloudflareRepository $settings, string $content)
    {
        $domain = $settings->domain_list;
        $result = $this->getInterface()->updateRecord($endpoint, $zone_id, $record_id, $type_dns, $domain, $content);
        return $result;
    }

    /**
     * @param DNS $endpoint
     * @param string $zone_id
     * @param string $record
     * @return string|null
     */
    public function getIdDns(DNS $endpoint, string $zone_id, string $record)
    {
        $id_dns = null;
        $dns = $this->listRecords($endpoint, $zone_id);
        if (isset($dns->result)) {
            foreach ($dns->result as $result) {
                if ($result->type === $record) {
                    $id_dns = $result->id;
                }
            }
        }
        return $id_dns;
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
     * @param Guzzle $adapter
     * @return mixed
     */
    public function setDnsEndpoint(Guzzle $adapter)
    {
        $dns_endpoint = $this->getInterface()->createDnsEndpoint($adapter);
        return $dns_endpoint;
    }
}
