<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 08:02
 */

namespace App\Repositories\Settings;

use App\Interfaces\Settings\SettingsCloudflareInterface;
use App\Repositories\BaseRepository;

class SettingsCloudflareRepository extends BaseRepository implements SettingsCloudflareInterface
{
    /**
     * @var string
     */
    protected $table = 'settings_cloudflare';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'api_key',
        'email',
        'domain_list'
    ];

    public function createOrUpdate(array $data, int $user_id)
    {
        $model = $this->updateOrCreate(
            [
                'user_id' => $user_id,
            ],
            [
                'api_key' => $data[ 'api_key' ],
                'email' => $data[ 'email' ],
                'domain_list' => $data ['domain_list' ]
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
