<?php

//App/Helpers/Shopify.php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Exceptions\InvalidMethodRequestException;

class Shopify {

    protected $api_key;
    protected $password;
    protected $url;
    protected $host;
    protected $secret;
    protected $client;

    public function __construct() {
        $this->api_key = env('SHOPIFY_API_KEY');
        $this->password = env('SHOPIFY_API_PASSWORD');
        $this->secret = env('SHOPIFY_API_SHARED_SECRET');
        $this->host = env('SHOPIFY_API_HOST');

        $this->url = "https://{$this->api_key}:{$this->password}@{$this->host}";
        $this->client = new Client();
    }
    public function apikey($url) {
        $headers = [
            // 'Authorization' => 'ApiKey key="256cf8a09ffccb2fc7b88fc9689b52df1d377c42"',
            'Authorization' => 'ApiKey key="222a4fb9733e434ed9e2199ef5ce2160dba8f860"',
            'Content-type'=> 'application/json',
            'x-api-version' =>'2.0'
        ];
       $withHeaders =  Http::withHeaders($headers)->get($url);
       return $withHeaders;
    }

    public function __call($method, $args)
    {
        $method = strtoupper($method);
        $allowedMethods = ['POST','GET','PUT','DELETE'];
        if(!in_array($method,$allowedMethods)){
            throw new InvalidMethodRequestException();
        }
        return $this->request($method,trim($args[0]),$args[1] ?? []);
    }

    protected function request(string $method, string $uri, array $payload)
    {
        $response = $this->client->request(
            $method,
            "{$this->url}{$uri}",
            [
                'query' => $payload
            ]
        );

        return json_decode($response->getBody());
    }

}
