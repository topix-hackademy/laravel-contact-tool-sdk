<?php
namespace Topix\Hackademy\ContactToolSdk\Classes;

class Api
{
    public $apiBaseUri = '';
    public $authToken = '';

    public function get($uri){
        return $this->call($uri);
    }
    public function post($uri, $data = []){
        return $this->call($uri, $method = 'POST', $data );
    }
    public function put($uri, $data = []){
        return $this->call($uri,  $method = 'PUT', $data );
    }
    public function delete($uri, $data = []){
        // Delete is not implemented. To delete a resource use PUT verb and change the field is_valid
        $data['is_valid'] = false;
        return $this->call($uri, $method = 'PUT', $data);

        // return $this->call($uri, $method = 'DELETE');
    }

    protected function call($uri, $method = 'GET', $data = []){

        $data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUri.$uri );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'AUTH-TOKEN: '.$this->authToken,
            'CONTENT-TYPE: application/json'
//            'CONTENT-LENGTH: '.strlen($data)
        ));
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        // DEBUG
//        curl_setopt($ch, CURLOPT_HEADER, 1);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        // END DEBUG

        if($method == 'POST'|| $method == 'post' || $method == 'Post'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        }
        if($method == 'PUT'|| $method == 'put' || $method == 'Put'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if($method == 'DELETE'|| $method == 'delete' || $method == 'Delete'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $response = curl_exec($ch);
        curl_close ($ch);

        return $response;

    }

//    public function urlify (Array $arr){
//
//        return implode('&', array_map(
//            function ($key, $val) {
//                if(is_array($val)){
//                    $val = '['.json_encode($val).']';
//                }
//                else $val = urlencode($val);
//
//                return urlencode($key) . '=' . $val;
//            }
//            , array_keys($arr), $arr));
//
//    }

}
