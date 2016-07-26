<?php
namespace Topix\Hackademy\ContactToolSdk\Api;
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

        $client = new \GuzzleHttp\Client();

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


//    public static function call($uri, $method = 'GET', $data = []){
//
//        $data = json_encode($data);
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, config('anagrafica.api-base-uri').$uri );
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'AUTH-TOKEN: '.config('anagrafica.auth-token'),
//            'CONTENT-TYPE: application/json'
////            'CONTENT-LENGTH: '.strlen($data)
//        ));
//        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
//        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//
//        // DEBUG
////        curl_setopt($ch, CURLOPT_HEADER, 1);
////        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
////        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//        // END DEBUG
//
//        if($method == 'POST'|| $method == 'post' || $method == 'Post'){
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//
//        }
//        if($method == 'PUT'|| $method == 'put' || $method == 'Put'){
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        }
//        if($method == 'DELETE'|| $method == 'delete' || $method == 'Delete'){
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//
//        }
//
//        $response = curl_exec($ch);
//        curl_close ($ch);
//
//        return $response;
//
//    }

}
