<?php
namespace Topix\Hackademy\ContactToolSdk\Contact\Traits;

use Topix\Hackademy\ContactToolSdk\Api\Client;
use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Company;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Contact;


trait Referable
{
    public $APIentities = [
        'contact' => "Topix\\Hackademy\\ContactToolSdk\\Api\\Entities\\Contact",
        'company' => "Topix\\Hackademy\\ContactToolSdk\\Api\\Entities\\Company",
    ];

    public function references()
    {
        return $this->morphOne('Topix\Hackademy\ContactToolSdk\Contact\Models\Contact', 'referable');
    }

    // Return contact data if exists else return false
    public function getContact(){

        if( $this->checkIfLocalExist() ){
            $contactType = $this->references->external_entity_name;
            $contactId = $this->references->external_id;

            $APIentity = new $contactType();
            return collect( \GuzzleHttp\json_decode($APIentity->get($contactId)) );
        }
        return false;

    }

    // Create Local An remote Contact
    public function createContact($type, Array $data){

        // If a local ref exist update the reference
        if( $this->checkIfLocalExist() )
            return $this->updateContact($data);

        // If there isn't a local reference create one
        $results = $this->createExternalContact($type, $data);

        // Check if results returns an error
        if( $results ) $this->createReference($results->id, $this->APIentities[$type]);
        return $results;

    }

    // Update Local An Remote Contact
    public function updateContact($data){

        // Get Local Polimorph related data
        $contactType = $this->references->external_entity_name;
        $contactId = $this->references->external_id;

        // Update Remote Entity trough API
        $results = $this->updateExternalContact($data);

        // Check if results returns an error
        if( $results ) $this->updateReference( $results->id, $contactType);
        return $results;

    }

    /* Remote Entities methods*/

    // Create Remote Entity trough API
    // Return false in case of error
    public function createExternalContact($contactType, Array $contactData){

        // Create API entity
        $APIentity = new $this->APIentities[$contactType]();
        $results = $APIentity->create($contactData);

        // Check if results returns an error
        if( $results ) return \GuzzleHttp\json_decode($results);
        return $results;

    }

    // Update Remote Entity trough API
    // Return false in case of error
    public function updateExternalContact(Array $contactData){

        // Get Local Polimorph related data
        $contactType = $this->references->external_entity_name;
        $contactId = $this->references->external_id;

        // Update Remote Entity trough API
        $APIentity = new $contactType();
        $results = $APIentity->update($contactId, $contactData);

        // Check if results returns an error
        if( $results ) return  \GuzzleHttp\json_decode($results);
        return false;
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

    // Check if local reference already exist
    public function checkIfLocalExist(){
        return count($this->references);
    }

}