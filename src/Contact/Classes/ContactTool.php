<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Classes;

use GuzzleHttp\Psr7\Response;
use Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable;


class ContactTool {

    public $APIentities = [
        'contact' => "Topix\\Hackademy\\ContactToolSdk\\Api\\Entities\\Contact",
        'company' => "Topix\\Hackademy\\ContactToolSdk\\Api\\Entities\\Company",
    ];

    /*
    *   Usage:   Get Remote Contact data
    *   Return:  Collection of Remote Contact data
    *   Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
    */
    public function getContact(iReferable $referable){

        if( $referable->checkIfLocalExist() ){

            $contactType = $referable->getLocalReference()->external_entity_name;
            $contactId = $referable->getLocalReference()->external_id;

            $APIentity = new $contactType();
            $results = $APIentity->get($contactId);

            if( ! $results instanceof Response ) return $this->jsonToCollection($results);;
            return $results;
        }
        return false;

    }
    
    /*
       * Usage:   Create Local An remote Contact
       * Return:  Collection of Remote Contact data
       * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
       */
    private function createReference(iReferable $referable, $ContactType, Array $data){

        // If a local ref exist update the reference
        if( $referable->checkIfLocalExist() )
            return $this->updateContact($referable, $data);

        // If there isn't a local reference create one
        $results = $this->createExternalReference($ContactType, $data);

        // Check if results returns an error
        if( ! $results instanceof Response ) $referable->createReference($results['id'], $this->APIentities[$ContactType]);
        return $results;

    }
    
    public function createContact(iReferable $referable, $data)
    {
        return $this->createReference($referable, 'contact', $data);
    }

    public function createCompany(iReferable $referable, $data)
    {
        return $this->createReference($referable, 'company', $data);
    }

    /*
     * Usage:   Update Local An Remote Contact
     * Return:  Collection with updated data
     * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
     */
    public function updateContact(iReferable $referable, $data){

        // Get Local Polimorph related data
        $contactType = $referable->getLocalReference()->external_entity_name;
        $contactId = $referable->getLocalReference()->external_id;

        // Update Remote Entity trough API
        $results = $this->updateExternalContact($referable, $data);

        return $results;

    }

    /* Remote Entities methods*/

    /*
    * Usage:   Create Remote Entity trough API
    * Return:  Collection with new data
    * Error:   In case of error Returns a 'GuzzleHttp\Psr7\Response' Object
    */
    public function createExternalContact($contactType, Array $contactData){

        // Create API entity
        $APIentity = new $this->APIentities[$contactType]();
        $results = $APIentity->create($contactData);

        // Check if results returns an error
        if( ! $results instanceof Response ) return $this->jsonToCollection($results);
        return $results;

    }

    /*
    * Usage:   Update Remote Entity trough API
    * Return:  Collection with updated data
    * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
    */
    public function updateExternalContact(iReferable $referable, Array $contactData){

        // Get Local Polimorph related data
        $contactType = $referable->getLocalReference()->external_entity_name;
        $contactId = $referable->getLocalReference()->external_id;

        // Update Remote Entity trough API
        $APIentity = new $contactType();
        $results = $APIentity->update($contactId, $contactData);

        // Check if results returns an error
        if( ! $results instanceof Response ) return  $this->jsonToCollection($results);
        return $results;
    }


    /* Helper methods*/

    // Convert json to collection
    public function jsonToCollection($json){
        return collect(\GuzzleHttp\json_decode($json));
    }

}