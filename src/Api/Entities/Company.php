<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Company extends Anagrafica
{
    protected $entity = 'company';

//    public function updateOrCreate(Array $data){
//        return $this->api->put($this->entity.'/', $data);
//    }

}
