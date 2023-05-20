<?php

namespace App\Repositories;

class RajaOngkirRepo
{
    public function __construct()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey(env('RAJA_ONGKIR_APP_KEY'));
        \Nekoding\Rajaongkir\Utils\Config::setApiMode(env('RAJA_ONGKIR_API_MODE'));
    }

    function getAllProvince()
    {
        return \Nekoding\Rajaongkir\Rajaongkir::province()->get();
    }

    function getAllCity()
    {
        return \Nekoding\Rajaongkir\Rajaongkir::City()->get();
    }

    public function getCostJne($from_city_id, $to_city_id)
    {
        $cost = \Nekoding\Rajaongkir\Rajaongkir::cost();
        $cost->setOrigin($from_city_id);
        $cost->setDestination($to_city_id);
        $cost->setWeight(1000);
        $cost->setCourier('jne');

        return $cost->get()['results'][0]['costs'][0]['cost'][0]['value'];
    }

    public function getCostTiki($from_city_id, $to_city_id)
    {
        $cost = \Nekoding\Rajaongkir\Rajaongkir::cost();
        $cost->setOrigin($from_city_id);
        $cost->setDestination($to_city_id);
        $cost->setWeight(1000);
        $cost->setCourier('tiki');

        return $cost->get()['results'][0]['costs'][0]['cost'][0]['value'];
    }

    public function getCostPos($from_city_id, $to_city_id)
    {
        $cost = \Nekoding\Rajaongkir\Rajaongkir::cost();
        $cost->setOrigin($from_city_id);
        $cost->setDestination($to_city_id);
        $cost->setWeight(1000);
        $cost->setCourier('pos');

        return $cost->get()['results'][0]['costs'][0]['cost'][0]['value'];
    }
}