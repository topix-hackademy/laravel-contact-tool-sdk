<?php
namespace Topix\Hackademy\ContactToolSdk\Contact\Traits;

use Topix\Hackademy\ContactToolSdk\Api\Client;
use Topix\Hackademy\ContactToolSdk\Api\ContactClient;
use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Company;
use Topix\Hackademy\ContactToolSdk\Api\Entities\Contact;


trait Referable
{

    public $entities = [
        'contact' => "Topix\\Hackademy\\ContactToolSdk\\Api\\Entities\\Contact",
        'company' => "Topix\\Hackademy\\ContactToolSdk\\Api\\Entities\\Company",
    ];

    public function references()
    {
        return $this->morphMany('Topix\Hackademy\ContactToolSdk\Contact\Models\Contact', 'referable');
    }

    // Create Entity on remote API
    public function createExternalContact($contactType, Array $contactData){

        $ref = ContactClient::post($contactType.'/', $contactData);
        return json_decode($ref);

    }

    public function updateExternalContact(Array $contactData){

        $contactType = $this->references[0]->external_entity_name;
        $contactId = $this->references[0]->external_id;

        $ref = ContactClient::put($contactType.'/'.$contactId.'/', $contactData);

        return  \GuzzleHttp\json_decode($ref);

    }

    // Create Local Reference
    public function createReference($id, $name){

        return $this->references()->create( [
            'external_id' => $id,
            'external_entity_name' => $name
        ]);

    }

    // Update Local Reference
    public function updateReference($name , $id){

        return $this->references()->update([
            'external_id' => $id,
            'external_entity_name' => $name
        ]);
    }

    public function createContact(Array $data){

//        $results = $this->createExternalContact('contact', $data);

        $results = json_decode( ContactClient::get('contact/14') );

        // @TODO check if results is an error
        if( property_exists ( $results , 'id' ) ){
            return $this->createReference($results->id, 'contact');
        }
        else return $results;

    }

    public function createCompany(Array $data){

        $results = $this->createExternalContact('company', $data);

        // @TODO check if results is an error
        if(property_exists ( $results , 'company_custom_id' ) ){
            return $this->createReference($results->company_custom_id, 'company');
        }
        else return $results;
    }

    public function updateContact($data){

        $results = $this->updateExternalContact($data);
        if(property_exists ( $results , 'id' )){
            return $this->updateReference('contact', $results->id);
        }

    }

    public function upadateCompany($data){
        $results = $this->updateExternalContact($data);

        // @TODO check if results is an error
        if(property_exists ( $results , 'company_custom_id' )){
            return $this->updateReference('company', $results->company_custom_id);
        }
    }


}