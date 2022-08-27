<?php

namespace App\Service;

use GuzzleHttp\Client;
use mysql_xdevapi\Exception;

class CurrencyService
{

    public static function getCurrencyAmount(): string
    {
        try {

            $client   = new Client();
            $request  = $client->get('https://developers.paysera.com/tasks/api/currency-exchange-rates');
            $response = $request->getBody()->getContents();

            return $response;

        } catch ( \Exception $e) {

            throw new Exception($e->getMessage());
        }

    }

}
