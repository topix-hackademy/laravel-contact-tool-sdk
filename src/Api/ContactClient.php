<?php
namespace Topix\Hackademy\ContactToolSdk\Api;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Topix\Hackademy\ContactToolSdk\Contact\Models\Contact as LocalContact;

class ContactClient
{

    /**
     * @param $uri
     * @return null|\Psr\Http\Message\ResponseInterface|string
     */
    public static function get($uri){
        return self::call($uri);
    }

    /**
     * @param $uri
     * @param array $data
     * @return null|\Psr\Http\Message\ResponseInterface|string
     */
    public static function post($uri, $data = []){
        return self::call($uri, $method = 'POST', $data );
    }

    /**
     * @param $uri
     * @param array $data
     * @return null|\Psr\Http\Message\ResponseInterface|string
     */
    public static function put($uri, $data = []){
		return self::call($uri,  $method = 'PUT', $data );
    }

    /**
     * @param $uri
     * @param array $data
     * @return null|\Psr\Http\Message\ResponseInterface|string
     */
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
			error_log("call: got client exception " . $e->getMessage());
            return $e->getResponse();
        }
		
        return $response->getBody()->getContents();

    }

}
