<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Traits;

use Topix\Hackademy\ContactToolSdk\Contact\Classes\ContactTool;
use Topix\Hackademy\ContactToolSdk\Contact\Models\Contact;

trait Referable
{
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
}