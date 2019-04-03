<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 08:04
 */

namespace App\Interfaces\Settings;

use App\Interfaces\BaseInterface;

interface SettingsInterface extends BaseInterface
{
    /**
     * @param int $user_id
     * @return mixed
     */
    public function getAllRecordsForAuthenticatedUser(int $user_id);
}
