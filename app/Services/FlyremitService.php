<?php
// app/Services/FlyremitService.php

namespace App\Services;

use GuzzleHttp\Client;

class FlyremitService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => "https://apitest.flyremit.com/api/",
        ]);
       
        $this->token = $this->getToken();
		return $this->token;
    }
    
    protected function getToken()
    {
        $endpoint = 'JWTLoginAuthentication';
        
        $headers = [
            'Content-Type' => 'application/json',
        ];
        
        $data = [
            'username' => "abatera",
            'password' => "95qruh2pur4acrm13hn3"
        ];
        
        $options = [
            'headers' => $headers,
            'json' => $data,
        ];
        
        $response = $this->client->request("POST", $endpoint, $options);

        $responseData = json_decode($response->getBody(), true);

        return $responseData['token'] ?? null;
    }

    public function registerAgent($data)
    {
		
		$client = new Client();
		$response = $client->request('POST', 'https://apitest.flyremit.com/api/abatera/CreateAgent', [
		'headers' => [
		'Authorization' => 'Bearer ' . $this->token,
			'Accept' => '*/*',
			'Content-Type' => 'application/json',
		],
		'json' => [
			'dmcid' => "31146",
			'agnetID' => $data['agentID'],
			'panNumber' => $data['panNumber'],
			'name' => $data['name'],
			'mobile' => $data['mobile'],
			'email' => $data['email'],
			'cityId' => $data['cityId'],
		],
	]);


        return json_decode($response->getBody(), true);
    }
}
?>
