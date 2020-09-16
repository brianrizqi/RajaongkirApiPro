<?php

namespace Brianrizqi\RajaongkirPro;

use Brianrizqi\RajaongkirPro\Api as Api;

class Subdistrict
{
    public $subdistrict_id, $city_id, $province_id, $province, $type, $city_name, $subdistrict_name;

    /**
     * Subdistrict constructor.
     * @param $subdistrict_id
     * @param $province_id
     * @param $province
     * @param $city_id
     * @param $city_name
     * @param $type
     * @param $subdistrict_name
     */

    public function __construct($subdistrict_id, $province_id, $province, $city_id, $city_name, $type, $subdistrict_name)
    {
        $this->subdistrict_id = $subdistrict_id;
        $this->province_id = $province_id;
        $this->province = $province;
        $this->city_id = $city_id;
        $this->city_name = $city_name;
        $this->type = $type;
        $this->subdistrict_name = $subdistrict_name;
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

    public function __toString()
    {
        return json_encode((array)$this);
    }
}
