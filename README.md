# RajaOngkirApiPRO

## Installation

Via Composer

``` bash
$ composer require brianrizqi/rajaongkirapipro
```

## Usage

add config from php artisan vendor:publish

add .env
```
RAJAONGKIR_ENDPOINTAPI=https://pro.rajaongkir.com/api/
RAJAONGKIR_APIKEY=your-api-key
RAJAONGKIR_ORIGIN=subdistrict_id or city_id
RAJAONGKIR_ORIGIN_TYPE=subdistrict or city 
```

```
Province::all() -> get all province
Province::find(id) -> get spesific province by id
Province::cities($province_id) -> get city from provinces
City::all() -> get all city
City::find(id) -> get spesific city by id
City::subdistrict($city_id) -> get subdistrict from city
Subdistrict::find($id) -> get spesific subdistrict by id
Api::calculateCost($city_id or $subdistrict_id, 'city' or 'subdistrict',weight, courier) -> check cost
Api::waybill($waybill,$courier)
```

## Security

If you discover any security related issues, please email rizqibrian27@gmail.com instead of using the issue tracker.

## License

license. Please see the [license file](license.md) for more information.
