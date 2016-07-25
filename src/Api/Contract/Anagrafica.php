<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Contract;

use Topix\Hackademy\ContactToolSdk\Api\Client;
use Topix\Hackademy\ContactToolSdk\Api\ContactClient;

abstract class Anagrafica
{
    protected $api;
    protected $entity;
    
    public function __construct()
    {

//        $this->api->apiBaseUri = config('anagrafica.api-base-uri');
//        $this->api->authToken = config('anagrafica.auth-token');
    }

    public function all(){
        return ContactClient::get($this->entity.'/');
    }
    public function get($id){
        return ContactClient::get($this->entity.'/'.$id.'/');
    }
    public function create(Array $data){
        return ContactClient::post($this->entity.'/', $data);
    }
    public function update($id, Array $data){
        return ContactClient::put($this->entity.'/'.$id.'/', $data);
    }
    public function delete($id, Array $data){
        return ContactClient::delete($this->entity.'/'.$id.'/', $data);
    }

}
