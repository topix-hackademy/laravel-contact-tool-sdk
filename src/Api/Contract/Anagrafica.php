<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Contract;

use Topix\Hackademy\ContactToolSdk\Api\Client;
use Topix\Hackademy\ContactToolSdk\Api\ContactClient;

abstract class Anagrafica implements iAnagrafica
{
    protected static $api;
    protected static $entity;
    
    public static function all(){
        return ContactClient::get(static::$entity.'/');
    }
    public static function get($id){
        if(is_numeric($id)) return ContactClient::get(static::$entity.'/'.$id.'/');
        return false;
    }
    public static function create(Array $data){
        if(static::validate($data)) return ContactClient::post(static::$entity.'/', $data);
        return false;
    }
    public static function update($id, Array $data){
        if(is_numeric($id) && static::validate($data)) return ContactClient::put(static::$entity.'/'.$id.'/', $data);
        return false;
    }
    public static function delete($id, Array $data){
        if(is_numeric($id) && static::validate($data)) return ContactClient::delete(static::$entity.'/'.$id.'/', $data);
        return false;
    }

    public static abstract function validate($data);
}
