<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 08:11
 */

namespace App\Gateways\Settings;

use App\Gateways\BaseGateway;
use App\Interfaces\SettingsInterface;

class SettingsUserGateway extends BaseGateway
{

    /**
     * The allowed settings.
     * @var array
     */
    private $allowed_settings = [
        'timezone'
    ];

    /**
     * SettingsUserGateway constructor.
     * @param \App\Interfaces\SettingsInterface $interface
     */
    public function __construct(SettingsInterface $interface)
    {
        $this->setInterface($interface);
    }

    public function createOrUpdate(array $data, int $user_id)
    {
        $status = false;

        if (count($data)>0) {
            foreach ($data as $key => $value) {
                if (in_array($key, $this->getAllowedSettings())) {
                    $this->getInterface()->createOrUpdate($key, $value, $user_id);
                    $status = true;
                }
            }
        }

        return $status;
    }

    /**
     * @param int $user_id
     * @return @return \Illuminate\Database\Eloquent\Collection $records
     */
    public function getAllRecordsForAuthenticatedUser(int $user_id)
    {
        $records = $this->getInterface()->getAllRecordsForAuthenticatedUser($user_id);
        return $records;
    }

    /**
     * @return array
     */
    private function getAllowedSettings(): array
    {
        return $this->allowed_settings;
    }
}
