<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Facades;

use Illuminate\Support\Facades\Facade;

class Contact extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'contact'; // Keep this in mind
    }

}