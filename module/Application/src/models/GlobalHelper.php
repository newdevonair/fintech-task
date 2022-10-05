<?php

namespace Application\Models;

use Laminas\Crypt\Password\Bcrypt;

final class GlobalHelper
{
    private function __construct()
    {

    }

    public static function encryptBcrypt(string $data): string
    {
        $bcryot = new Bcrypt(
            [
                'cost' => 12,
            ]
        );
        return $bcryot->create($data);
    }

    /**
     * @param string $data
     * @param string $bcrypt
     * @return bool
     */
    public static function verifyBcrypt(string $data, string $bcrypt): bool
    {
        $bcryot = new Bcrypt();
        return $bcryot->verify($data, $bcrypt);
    }

    /**
     * @param string $currency
     * @param string $amount
     * @return void
     */
    public function currencyConverter(string $currency, string $amount): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=USD&to={$currency}&amount={$amount}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: currency-converter5.p.rapidapi.com",
                "X-RapidAPI-Key: 5d6f11849bmsh825fb1a3d875641p17dfaejsn810a200ad963"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
