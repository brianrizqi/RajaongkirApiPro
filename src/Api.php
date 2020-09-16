<?php

namespace Brianrizqi\RajaongkirPro;


use Illuminate\Support\MessageBag;

class Api
{
    protected $baseurl;
    protected $apikey;
    protected $origin;
    protected $origin_type;

    public function __construct()
    {
        $this->baseurl = config('rajaongkirpro.rajaongkir_endpoint', 'https://pro.rajaongkir.com/api/');
        $this->apikey = config('rajaongkirpro.rajaongkir_key', '');
        $this->origin = config('rajaongkirpro.rajaongkir_origin', '');
        $this->origin_type = config('rajaongkirpro.rajaongkir_origin_type', '');
    }

    public function all($class)
    {
        $arr = [];
        $param = strtolower(substr($class, strrpos($class, '\\') + 1));
        foreach (json_decode($this->requestApi($param))->rajaongkir->results as $result) {
            array_push($arr, new $class(...array_values((array)$result)));
        }
        return $arr;
    }

    public function find($class, $id)
    {
        $endpoint = strtolower(substr($class, strrpos($class, '\\') + 1)) . "?id=$id";
        $result = json_decode($this->requestApi($endpoint))->rajaongkir->results;
        return $result === [] ? null : new $class(...array_values((array)$result));
    }

    public function query($class, $query)
    {
        $arr = [];
        $endpoint = strtolower(last(explode('\\', $class))) . "?" . $query;
        foreach (json_decode($this->requestApi($endpoint))->rajaongkir->results as $result) {
            array_push($arr, new $class(...array_values((array)$result)));
        }
        return $arr;
    }

    public static function calculateCost($destination, $destinationType, $weight, $courier)
    {
        $api = new Api;
        $origin = $api->origin;
        $originType = $api->origin_type;
        $params = http_build_query(compact('origin', 'originType', 'destination', 'destinationType', 'weight', 'courier'));
        $response = json_decode($api->requestApi('cost', 'POST', $params))->rajaongkir;
        if ($response->status->code === 200) {
            $origin_detail = $originType === 'subdistrict' ? new Subdistrict(...array_values((array)$response->origin_details)) : new City(...array_values((array)$response->origin_details));
            $destination_detail = $destinationType === 'subdistrict' ? new Subdistrict(...array_values((array)$response->destination_details)) : new City(...array_values((array)$response->destination_details));
            $costs = [];
            foreach ($response->results[0]->costs as $cost) {
                array_push($costs, new CourierCost(
                    $cost->service,
                    $cost->description,
                    $cost->cost[0]->value,
                    $cost->cost[0]->etd,
                    $cost->cost[0]->note
                ));
            }
            $courier = new Courier($response->results[0]->code, $response->results[0]->name, $costs);
            return new Cost($origin_detail, $destination_detail, $courier);
        } else {
            $errors = new MessageBag();
            $errors->add('rajaongkir', $response->status->description);
            return $errors;
        }
    }

    public static function waybill($waybill, $courier)
    {
        $api = new Api;
        $params = http_build_query(compact('waybill', 'courier'));
        $response = json_decode($api->requestApi('waybill', 'POST', $params))->rajaongkir;
        if ($response->status->code === 200) {

        } else {
            $errors = new MessageBag();
            $errors->add('rajaongkir', $response->status->description);
            return $errors;
        }
        return $response;
    }

    public function requestApi($endpoint, $method = 'GET', $params = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->baseurl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                "key: " . $this->apikey
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }
}


