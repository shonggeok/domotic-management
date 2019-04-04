<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 08:11
 */

namespace App\Gateways\Settings;

use App\Gateways\BaseGateway;
use App\Interfaces\Settings\SettingsCloudflareInterface;
use Illuminate\Support\Facades\Validator;

class SettingsCloudflareGateway extends BaseGateway
{

    /**
     * SettingsCloudflareGateway constructor.
     * @param \App\Interfaces\SettingsInterface $interface
     */
    public function __construct(SettingsCloudflareInterface $interface)
    {
        $this->setInterface($interface);
    }

    /**
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Collection $records
     */
    public function getAllRecordsForAuthenticatedUser(int $user_id)
    {
        $records = $this->getInterface()->getAllRecordsForAuthenticatedUser($user_id);
        return $records;
    }

    /**
     * @param array $data
     * @param int $user_id
     * @return array|bool
     */
    public function createOrUpdate(array $data, int $user_id)
    {
        $rules = [
            'api_key' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'email'
            ],
            'domain_list' => [
                'required',
                'string'
            ]
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $this->getInterface()->createOrUpdate($data, $user_id);
            return true;
        }
    }
}
