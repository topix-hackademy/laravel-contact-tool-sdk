<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Contact extends Anagrafica
{
    protected $entity = 'contact';

    public function findByMail($email){
        return ContactClient::get('/contact-by-email/'.$email);
    }

}
