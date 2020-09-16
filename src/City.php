<?php

namespace Brianrizqi\RajaongkirPro;

use Brianrizqi\RajaongkirPro\Api as Api;

class City
{
    public $city_id, $province_id, $province, $type, $city_name, $postal_code;

    /**
     * City constructor.
     * @param $city_id
     * @param $province_id
     * @param $province
     * @param $type
     * @param $city_name
     * @param $postal_code
     */

    public function __construct($city_id, $province_id, $province, $type, $city_name, $postal_code)
    {
        $this->city_id = $city_id;
        $this->province_id = $province_id;
        $this->province = $province;
        $this->type = $type;
        $this->city_name = $city_name;
        $this->postal_code = $postal_code;
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

    public static function subdistrict($city_id)
    {
        $response = (new Api)->query(Subdistrict::class, 'city=' . $city_id);
        return $response;
    }

    public function __toString()
    {
        return json_encode((array)$this);
    }
}
