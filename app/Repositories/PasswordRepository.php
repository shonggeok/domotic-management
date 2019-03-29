<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 27/03/2019
 * Time: 09:47
 */

namespace App\Repositories;

use App\Interfaces\PasswordInterface;
use Illuminate\Support\Facades\Hash;

class PasswordRepository extends BaseRepository implements PasswordInterface
{

    /**
     * @var string
     */
    protected $table = 'users';


    /**
     * @param array $data
     * @param int $user_id
     * @return bool
     */
    public function updatePassword(array $data, int $user_id)
    {
        $is_valid = $this->validatePassword($data['old_password'], $user_id);
        if ($is_valid === true) {
            $user = $this->find($user_id);
            $user->password = Hash::make($data['new_password']);
            $user->save();
        }
        return $is_valid;
    }


    /**
     * @param string $old_password
     * @param int $user_id
     * @return bool
     */
    private function validatePassword(string $old_password, int $user_id)
    {
        $is_valid = false;
        $user = $this->where('id', $user_id)->get();
        if ($user->count() === 1) {
            if (Hash::check($old_password, $user[0]->password)) {
                $is_valid = true;
            }
        }
        return $is_valid;
    }
}
