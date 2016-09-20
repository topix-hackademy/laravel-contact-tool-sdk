<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Classes;

use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Collection;
use Topix\Hackademy\ContactToolSdk\Api\Contract\iAnagrafica;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Company;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Contact;
use Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable;

class ContactTool {


    /**
     * Array of necessary api entities
     * @var array
     */
    public $APIentities = [
        'contact' => Contact::class,
        'company' => Company::class
    ];


    /**
     * @param iReferable $referable
     * @param $data
     * @param null $ref
     * @return bool|\Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    public function createContact(iReferable $referable, $data, $ref = null)
    {
        return $this->createReference($referable, 'contact', $data, $ref);
    }

    /**
     * @param iReferable $referable
     * @param $data
     * @param null $ref
     * @return bool|\Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    public function createCompany(iReferable $referable, $data, $ref = null)
    {
        return $this->createReference($referable, 'company', $data, $ref);
    }
    /*
   * Usage:   Create Local An remote Contact
   * Return:  Collection of Remote Contact data
   * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
   */
    /**
     * @param iReferable $referable
     * @param $ContactType
     * @param array $data
     * @param null $remoteId
     * @return bool|\Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    private function createReference(iReferable $referable, $ContactType, Array $data, $remoteId = null)
    {

        // If not local reference
        if ( ! ReferableTools::hasLocalReference($referable) ) {

            if ($remoteId != null) {
                /**
                 * @var $APIentity iAnagrafica
                 */
                $APIentity = new $this->APIentities[$ContactType];
                $results = $APIentity::update($remoteId, $data);
            }
            else {
                // If only remote exist create local
                $results = $this->createExternalContact($ContactType, $data);
            }

            if (!$results && !$results instanceof Response) ReferableTools::createLocalReference($referable, $results['id'], $this->APIentities[$ContactType]);

            return $results;

        }

        // @TODO: Check if this is the correct return format
        return $this->getReference($referable);

    }

    /*
    *   Usage:   Get Remote Contact data
    *   Return:  Collection of Remote Contact data
    *   Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
    */
    /**
     * get the remote reference of the iReferable object
     * @param iReferable $referable
     * @return bool|\Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    public function getReference(iReferable $referable){

        if( ReferableTools::hasLocalReference($referable) ){

            $reference = ReferableTools::getLocalReference($referable)->first();

            $contactType = $reference->external_entity_name;

            $contactId = $reference->external_id;

            /**
             * @var $APIentity iAnagrafica
             */
            $APIentity = new $contactType();
            $results = $APIentity::get($contactId);
            /*
             * exception???
             */
            if( ! $results instanceof Response ) return static::jsonToCollection($results);;
            return $results;
        }
        return false;
    }

    /*
     * Usage:   Update Local An Remote Contact
     * Return:  Collection with updated data
     * Error:   Returns a 'GuzzleHttp\Psr7\Response' Object
     */
    public function updateReference(iReferable $referable, $data){

        // Get Local Polimorph related data
        $reference = ReferableTools::getLocalReference($referable)->first();

        $contactType = $reference->external_entity_name;
        $contactId = $reference->external_id;

        // Update Remote Entity trough API
        $results = $this->updateExternalContact($contactType, $contactId, $data);

        return $results;

    }
    /**
     * get a single contact from main remote by email
     * @param $email string
     * @return \Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    public function getContactByEmail($email){

        $contactType = $this->APIentities['contact'];
        /**
         * @var $APIentity Contact
         */
        $APIentity = new $contactType();
        $results = $APIentity::getByEmail($email);

        if( ! $results instanceof Response )return static::jsonToCollection($results);
        return $results;

    }
    /**
     * get a single company from main remote by code
     * @param $code string
     * @return \Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    public function getCompanyByCode($code){

        $contactType = $this->APIentities['company'];
        /**
         * @var $APIentity Company
         */
        $APIentity = new $contactType();
        $results = $APIentity::getByCode($code);

        if( ! $results instanceof Response )return $this->jsonToCollection($results);
        return $results;

    }

    /**
     *
     * Get all remote entities for a given entity type
     *
     * @param $contactType string
     * @return array|Collection
     */
    public function getAllReference($contactType){

        $contactType = $this->APIentities[$contactType];
        /**
         * @var $APIentityInstance iAnagrafica
         */
        $APIentityInstance = new $contactType();

        $results = $APIentityInstance::all();
//        $localReferenceFiltered = LocalContact::where('external_entity_name', $contactType)->get();
//
//        $results = new Collection();
//
//        foreach($localReferenceFiltered as $local){
//
//            $id = $local->external_id;
//
//            $response = $APIentityInstance->get($id);
//
//            if( ! $response instanceof Response)
//                $results[] = json_decode($response);
//
//        }
        //TODO: probabilmente i dati saranno formattati in maniera diversa
        return static::jsonToCollection($results);

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
    public function updateExternalContact($contactType, $contactId, Array $contactData){

        // Update Remote Entity trough API
        $APIentity = new $contactType();
        $results = $APIentity->update($contactId, $contactData);

        // Check if results returns an error
        if( ! $results instanceof Response ) return  $this->jsonToCollection($results);
        return $results;
    }

    /* Helper methods*/

    // Convert json to collection
    private static function jsonToCollection($json){
        return collect(\GuzzleHttp\json_decode($json));
    }

}