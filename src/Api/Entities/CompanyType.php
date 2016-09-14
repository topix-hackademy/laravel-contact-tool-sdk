<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Entities;

use Topix\Hackademy\ContactToolSdk\Api\Contract\Anagrafica;

class CompanyType extends Anagrafica
{
    protected static $entity = 'company-type';

    public static function validate($data)
    {
        // TODO: Implement validate() method.

        return false;
    }
}
