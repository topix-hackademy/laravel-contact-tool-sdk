<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Traits;

use Topix\Hackademy\ContactToolSdk\Contact\Classes\ContactTool;
use Topix\Hackademy\ContactToolSdk\Contact\Models\Contact;

trait Referable
{

    public $referenceType = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function references()
    {
        return $this->morphOne(Contact::class, 'referable');

    }

    /**
     * Estra le informazioni memorizzate sull'anagrafica rispetto questa entità
     * @return mixed
     */
    public function getReference()
    {
        return app('contactTool')->getReference($this);
    }
    public function updateReference($data)
    {
        return app('contactTool')->updateReference($this, $data);
    }


    public function createReference($data, $id = null)
    {
        switch($this->referenceType){
            case 'company':
                return $this->createCompany($data, $id);
                break;
            case 'contact':
                return $this->createContact($data,$id);
                break;
            default:
                return null;
        }
    }

    /**
     * @param $data
     * @param null $id
     * @return bool|\Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    private function createCompany($data, $id = null)
    {
        return app('contactTool')->createCompany($this, $data, $id);
    }

    /**
     * @param $data
     * @param null $id
     * @return bool|\Illuminate\Support\Collection|null|\Psr\Http\Message\ResponseInterface|string
     */
    private function createContact($data, $id = null)
    {
        return app('contactTool')->createContact($this, $data, $id);
    }

}