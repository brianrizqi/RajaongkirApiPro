<?php

namespace Brianrizqi\RajaongkirPro;

class Cost
{
    public $origin, $destination, $courier;

    /**
     * CourierCost constructor.
     * @param $origin
     * @param $destination
     * @param $courier
     */

    public function __construct($origin, $destination, $courier)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->courier = $courier;
    }

    public function __toString()
    {
        return json_encode((array)$this);
    }

}
