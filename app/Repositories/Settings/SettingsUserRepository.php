<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 08:02
 */

namespace App\Repositories\Settings;

use App\Repositories\BaseRepository;
use App\Interfaces\Settings\SettingsUserInterface;

class SettingsUserRepository extends BaseRepository implements SettingsUserInterface
{
    /**
     * @var string
     */
    protected $table = 'settings_user';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'option_key',
        'option_value'
    ];


    /**
     * @param string $key The value where to search
     * @param string $value The new/updated value
     * @param int $user_id
     * @return \App\Repositories\Settings\SettingsUserRepository $model
     */
    public function createOrUpdate(string $key, string $value, int $user_id)
    {
        $model = $this->updateOrCreate(
            [
                'user_id' => $user_id,
                'option_key' => $key,
            ],
            [
                'option_key' => $key,
                'option_value' => $value,
            ]
        );
        return $model;
    }

    /**
     *
     * Return an array of Collections
     *
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Collection $model
     */
    public function getAllRecordsForAuthenticatedUser(int $user_id)
    {
        $model = $this->where('user_id', $user_id)->get();
        return $model;
    }
}
