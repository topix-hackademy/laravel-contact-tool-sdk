<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Contact extends Anagrafica
{
    protected static $entity = 'contact';

    public static function getByEmail($email){
        return ContactClient::get('/contact-by-email/'.$email);
    }

    public static function validate($data)
    {
        // TODO: Implement validate() method
        return true;
    }
}
