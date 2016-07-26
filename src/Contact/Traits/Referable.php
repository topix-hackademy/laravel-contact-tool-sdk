<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Traits;

use GuzzleHttp\Psr7\Response;

trait Referable
{

    public function references()
    {
        return $this->morphOne('Topix\Hackademy\ContactToolSdk\Contact\Models\Contact', 'referable');
    }


    /* Local Entities Methods*/

    // Create Local Reference
    public function createReference($id, $name){

        return $this->references()->create( [
            'external_id' => $id,
            'external_entity_name' => $name
        ]);

    }

    // Update Local Reference
    public function updateReference($id, $name){

        return $this->references()->update([
            'external_id' => $id,
            'external_entity_name' => $name
        ]);
    }

    /* Helper methods*/

    // Reurn loacal Reference
    public function getLocalReference(){
        return $this->references;
    }

    // Check if local reference already exist
    public function checkIfLocalExist(){
        return count($this->references);
    }

}