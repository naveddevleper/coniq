<?php

//App/Helpers/Shopify.php

namespace App\Helpers;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Exceptions\InvalidMethodRequestException;

class Shopify {

    protected $api_key;
    protected $api_access_token;
    protected $password;
    protected $url;
    protected $host;
    protected $secret;
    protected $client;

    public function __construct() {
        $this->api_key = env('SHOPIFY_API_KEY');
        $this->api_access_token = env('ACCESS_TOKEN');

        $this->password = env('NEW_SECRET_KEY');
        $this->secret = env('SHOPIFY_API_SECRET');
        $this->host = env('SHOPIFY_API_HOST');
        $this->api_scopes  = env('SHOPIFY_API_SCOPES');

        $this->url = "https://{$this->api_key}:{$this->api_access_token}@{$this->host}";
        $this->client = new Client();
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
    public function apikey($url) {

        $allowedMethods = ['POST','GET','PUT','DELETE'];
        $headers = [
            // 'Authorization' => 'ApiKey key="256cf8a09ffccb2fc7b88fc9689b52df1d377c42"',

            'Content-type'=> 'application/json',
            'Authorization' => 'ApiKey key="222a4fb9733e434ed9e2199ef5ce2160dba8f860"',
            'x-api-version' =>'2.0'
        ];
       $withHeaders =  Http::withHeaders($headers)->get($url);
       return $withHeaders;
    }

}
