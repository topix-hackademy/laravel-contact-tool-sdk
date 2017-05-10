<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Contact extends Anagrafica
{
    protected static $entity = 'contact';

    public static function getByEmail($email){
        return ContactClient::get('/contact-by-email/' . rawurlencode($email));
    }

    public static function getByUsername($username){
        return ContactClient::get('/contact-by-username/' . rawurlencode($username));
    }

    public static function validate($data)
    {
        // TODO: Implement validate() method
        return true;
    }
}
