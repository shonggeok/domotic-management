<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 08:15
 */

namespace App\Repositories;

use App\Interfaces\PublicIPInterface;

class PublicIPRepository extends BaseRepository implements PublicIPInterface
{

    /**
     * The name of table on database
     * @var string The table name on database
     */
    protected $table = "public_ip";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address'
    ];

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection $collection
     */
    public function createOrUpdate(array $data)
    {
        $model = $this->updateOrCreate(
            [
                'ip_address' => $data[ 'previous_ip_address' ]
            ],
            [
                'ip_address' => $data[ 'ip_address' ]
            ]
        );
        return $model;
    }

    /**
     * Return all objects in database
     *
     * @return \Illuminate\Database\Eloquent\Collection $collection
     */
    public function getAllRecords()
    {
        $collection = $this->all();
        return $collection;
    }
}
