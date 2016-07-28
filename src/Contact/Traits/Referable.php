<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Traits;

use Topix\Hackademy\ContactToolSdk\Contact\Classes\ContactTool;
use Topix\Hackademy\ContactToolSdk\Contact\Models\Contact;

trait Referable
{
    public function references()
    {
        return $this->morphOne(Contact::class, 'referable');

    }

    /* Local Entities Methods*/

    // Create Local Reference
    public function createLocalReference($id, $name){

        return $this->references()->create( [
            'external_id' => $id,
            'external_entity_name' => $name
        ]);

    }

    // Update Local Reference
    public function updateLocalReference($id, $name){

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
    
    public function getReference()
    {
        return app('contactTool')->getReference($this);
    }
    public function updateReference($data)
    {
        return app('contactTool')->updateReference($this, $data);
    }
    public function createCompany($data)
    {
        return app('contactTool')->createCompany($this, $data);
    }
    public function createContact($data)
    {
        return app('contactTool')->createContact($this, $data);
    }
    public function getReferenceByEmail($email){
        return app('contactTool')->getReferenceByEmail($email);
    }

}