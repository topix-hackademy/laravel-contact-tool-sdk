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
        return $this->morphMany('Topix\Hackademy\ContactToolSdk\Contact\Models\Contact', 'referable');
    }

    public function getContact(){

        if( $this->checkIfLocalExist() ){
            $contactType = $this->references[0]->external_entity_name;
            $contactId = $this->references[0]->external_id;

            $APIentity = new $contactType();
            return collect( \GuzzleHttp\json_decode($APIentity->get($contactId)) );
        }
        return false;

    }

    /*
     *  Create entitiy on API
     *  $type: name of the entity in API (eg: contact, company ..)
     *
     */

    public function createContact($type, Array $data){

        // If a local ref exist update the reference
        if( $this->checkIfLocalExist() )
            return $this->updateContact($data);

        // If there isn't a local reference create one
        $results = $this->createExternalContact($type, $data);

        // @TODO check if results is an error
        if( $results ) return $this->createReference($results->id, $this->APIentities[$type]);
        return false;

    }

    // Update External Contact
    public function updateContact($data){

        // Get Local Polimorph related data
        $contactType = $this->references[0]->external_entity_name;
        $contactId = $this->references[0]->external_id;

        // Update Remote Entity trough API
        $results = $this->updateExternalContact($data);

        if( $results ) return $this->updateReference( $results->id, $contactType);
        return false;

    }

    /*
     * API
     *
    */

    // Create Remote Entity trough API
    // Return false in case of error
    public function createExternalContact($contactType, Array $contactData){

        // Create API entity
        $APIentity = new $this->APIentities[$contactType]();
        $results = $APIentity->create($contactData);

        if( $results ) return \GuzzleHttp\json_decode($results);
        return false;

    }

    // Update Remote Entity trough API
    // Return false in case of error
    public function updateExternalContact(Array $contactData){

        // Get Local Polimorph related data
        $contactType = $this->references[0]->external_entity_name;
        $contactId = $this->references[0]->external_id;

        // Update Remote Entity trough API
        $APIentity = new $contactType();
        $results = $APIentity->update($contactId, $contactData);

        if( $results ) return  \GuzzleHttp\json_decode($results);
        return false;
    }

    /*
     * Local Entity
     *
    */

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

    // Check if local reference already exist

    public function checkIfLocalExist(){
        return count($this->references);
    }

}