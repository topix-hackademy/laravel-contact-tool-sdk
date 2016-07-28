<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Company extends Anagrafica
{
    protected $entity = 'company';

    public function getByCode($code){
        return ContactClient::get('/company-by-code/'.$code);
    }


}
