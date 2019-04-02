<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 27/03/2019
 * Time: 09:46
 */

namespace App\Gateways;

use App\Interfaces\PasswordInterface;
use Illuminate\Support\Facades\Validator;

class PasswordGateway extends BaseGateway
{

    /**
     * PasswordGateway constructor.
     * @param \App\Interfaces\PasswordInterface $interface
     */
    public function __construct(PasswordInterface $interface)
    {
        $this->setInterface($interface);
    }

    /**
     * @param array $data
     * @param int $user_id
     * @return array|bool
     */
    public function updatePassword(array $data, int $user_id)
    {
        $rules = [
            'old_password' => [
                'required',
                'string'
            ],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'min:8'
            ]
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            $update = $this->getInterface()->updatePassword($data, $user_id);
            return $update;
        }
    }
}
