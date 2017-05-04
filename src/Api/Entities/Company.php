<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Company extends Anagrafica
{
    protected static $entity = 'company';

    public static function getByCode($code){
        return ContactClient::get('/company-by-code/'.$code);
    }

    public static function getFreesearch($freesearch){
        return ContactClient::get('/company-freesearch/'.$freesearch);
    }


    public static function validate($data)
    {
        // TODO: Implement validate() method.
        return true;
    }
}
