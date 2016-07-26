<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Facades;

use Illuminate\Support\Facades\Facade;

class ContactTool extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'contactTool'; // Keep this in mind
    }

}