<?php

namespace Brianrizqi\RajaongkirPro;

class CourierCost
{
    public $service, $description, $value, $etd, $note;

    /**
     * Cost constructor.
     * @param $service
     * @param $description
     * @param $options
     */
    public function __construct($service, $description, $value, $etd = '', $note = '')
    {
        $this->service = $service;
        $this->description = $description;
        $this->value = $value;
        $this->etd = $etd;
        $this->note = $note;
    }

    public function __toString()
    {
        return json_encode((array)$this);
    }
}

