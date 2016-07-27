<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Facades;

use Illuminate\Support\Facades\Facade;

class CompanyType extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'contactType'; // Keep this in mind
    }

}