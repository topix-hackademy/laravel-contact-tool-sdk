<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Classes;

use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Collection;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Company;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Contact;
use Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable;
use Topix\Hackademy\ContactToolSdk\Contact\Models\Contact as LocalContact;


class ContactTool {

    public $APIentities = [
        'contact' => Contact::class,
        'company' => Company::class
    ];

    /*
    *   Usage:   Get Remote Contact data
    *   Return:  Collection of Remote Contact data
    *   Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
    */
    public function getReference(iReferable $referable){

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

    public function getContactByEmail($email){

        $contactType = $this->APIentities['contact'];
        $APIentity = new $contactType();
        $results = $APIentity->getByEmail($email);

        if( ! $results instanceof Response )return $this->jsonToCollection($results);
        return $results;

    }

    public function getCompanyByCode($code){

        $contactType = $this->APIentities['company'];
        $APIentity = new $contactType();
        $results = $APIentity->getByCode($code);

        if( ! $results instanceof Response )return $this->jsonToCollection($results);
        return $results;

    }

    public function getAllReference($contactType){

        $contactType = $this->APIentities[$contactType];
        $APIentityInstance = new $contactType();

        $localReferenceFiltered = LocalContact::where('external_entity_name', $contactType)->get();

        $results = new Collection();

        foreach($localReferenceFiltered as $local){

            $id = $local->external_id;

            $response = $APIentityInstance->get($id);

            if( ! $response instanceof Response)
                $results[] = json_decode($response);

        }
        return $results;

    }

    /*
       * Usage:   Create Local An remote Contact
       * Return:  Collection of Remote Contact data
       * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
       */
    private function createReference(iReferable $referable, $ContactType, Array $data, $remoteId = null){

        // get external data if exists
        $external = $this->getReference($referable) ;

        // If a local and remote ref exist update the remote
        if( $referable->checkIfLocalExist() && ! $external instanceof Response )
            return $this->updateReference($referable, $data);

        // If local and remote doesnt exist create both
        if( ! $referable->checkIfLocalExist()) {

            if( $remoteId != null ){
                $APIentity = new $this->APIentities[$ContactType];
                $results = $this->jsonToCollection($APIentity->update($remoteId ,$data));
            }
            else
                $results = $this->createExternalContact($ContactType, $data);


            // Check if results returns an error
            if (!$results instanceof Response) $referable->createLocalReference($results['id'], $this->APIentities[$ContactType]);
            return $results;
        }
        // If only remote exist create local
        else {
            if (!$external instanceof Response) $referable->createLocalReference($external['id'], $this->APIentities[$ContactType]);
            return $external;
        }

    }

    public function findRemote($contactType, Array $data){

        $APIentity = new $this->APIentities[$contactType];
        $idExist = isset($data['id']);
        $remote = $idExist? $APIentity->get($data['id']) : false;

        // If data contains an id - assume it exist on remote
        if( $remote )
            return $remote;

        // If data doesn't contains an id - search remote by field
        if($contactType == 'company')
            return $this->getCompanyByCode($data['company_tax_code']);

        if($contactType == 'contact')
            return $this->getContactByEmail($data['contact_email']);

        return false;

    }

    public function createContact(iReferable $referable, $data, $ref = null)
    {
        return $this->createReference($referable, 'contact', $data, $ref);
    }

    public function createCompany(iReferable $referable, $data, $ref = null)
    {
        return $this->createReference($referable, 'company', $data, $ref);
    }

    /*
     * Usage:   Update Local An Remote Contact
     * Return:  Collection with updated data
     * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
     */
    public function updateReference(iReferable $referable, $data){

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