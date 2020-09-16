<?php

namespace Brianrizqi\RajaongkirPro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Brianrizqi\RajaongkirPro\Api as Api;

class Province
{
    public $province_id, $province;

    /**
     * Province constructor.
     * @param $province_id
     * @param $province
     */

    public function __construct($province_id, $province)
    {
        $this->province_id = $province_id;
        $this->province = $province;
    }

    public static function all()
    {
        $response = (new Api)->all(self::class);
        return collect($response);
    }

    public static function find($id)
    {
        $response = (new Api)->find(self::class, $id);
        return $response;
    }

    public static function cities($province_id)
    {
        $response = (new Api)->query(City::class, 'province=' . $province_id);
        return $response;
    }

    public function __toString()
    {
        return json_encode((array)$this);
    }
}
