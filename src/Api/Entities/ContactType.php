<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class ContactType extends Anagrafica
{
    protected static $entity = 'role';

    public static function validate($data)
    {
        // TODO: Implement validate() method.

        return false;
    }
}
