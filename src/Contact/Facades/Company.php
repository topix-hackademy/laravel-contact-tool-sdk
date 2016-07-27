<?php

namespace Topix\Hackademy\ContactToolSdk\Contact\Facades;

use Illuminate\Support\Facades\Facade;

class Company extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'company'; // Keep this in mind
    }

}