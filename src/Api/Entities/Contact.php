<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class Contact extends Anagrafica
{
    protected $entity = 'contact';

//    public function updateOrCreate(Array $data){
//        return $this->api->put($this->entity.'/', $data);
//    }

}
