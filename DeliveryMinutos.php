<?php

namespace Delivery;

use ErrorException;

class Delivery_minutos
{
    private $client_id = 'YOUR_CLIENT_ID';
    private $client_secret = 'YOUR_CLIENT_SECRET';
    private $api_key = 'YOUR_API_KEY';
    public $url = 'https://sandbox.99minutos.com';
    public $token_auth;
    public $request;
    public $method;
    public $data;

    public function __construct()
    {
        if (!isset($_COOKIE['delivery_token_auth'])) {
            $this->token_auth = $this->get_token();
            setcookie('delivery_token_auth', $this->token_auth, time() + 3600);
        } else {
            $this->token_auth = $_COOKIE['delivery_token_auth'];
        }
    }

    public function get_token()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . '/api/v3/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "client_id":"' . $this->client_id . '",
                "client_secret":"' . $this->client_secret . '"
            }
            ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));


        $response = curl_exec($curl);
        $responseJson = json_decode($response);
        curl_close($curl);

        if (isset($responseJson->access_token)) {
            return $responseJson->access_token;
        }

        throw new ErrorException($responseJson->message);
    }

    public function request($request, $method, $data)
    {
        $curl = curl_init();
        $dataString = '';
        if (!empty($data)) {
            $dataString = json_encode($data);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . '/api/v3/' . $request,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $dataString,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->token_auth
            ),
        ));

        $response = curl_exec($curl);
        $responseJson = json_decode($response);
        curl_close($curl);
        return $responseJson;
    }
}
