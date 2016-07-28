<?php
namespace Topix\Hackademy\ContactToolSdk\Api;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ContactClient
{

    public static function get($uri){
        return self::call($uri);
    }
    public static function post($uri, $data = []){
        return self::call($uri, $method = 'POST', $data );
    }
    public static function put($uri, $data = []){
        return self::call($uri,  $method = 'PUT', $data );
    }

    public static function delete($uri, $data = []){
        // Delete is not implemented. To delete a resource use PUT verb and change the field is_valid
        $data['is_valid'] = false;
        return self::call($uri, $method = 'PUT', $data);

        // return self::call($uri, $method = 'DELETE');
    }

    public static function call($uri, $method = 'GET', $data = []){

        $client = new Client();

        $options = [ 'headers' =>
            [
                'AUTH-TOKEN' => config('anagrafica.auth-token'),
                'CONTENT-TYPE' => 'application/json'
            ]
        ];

        if($method == 'POST'|| $method == 'PUT' || $method == 'DELETE')
            $options['json'] = $data;

        try {
            $response = $client->request($method, config('anagrafica.api-base-uri').$uri, $options);
        } catch (ClientException $e) {
            return $e->getResponse();
        }

        return $response->getBody()->getContents();

    }

}
