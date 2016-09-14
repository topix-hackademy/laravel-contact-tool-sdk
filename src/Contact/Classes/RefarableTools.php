<?php
/**
 * Created by PhpStorm.
 * User: gab88slash
 * Date: 14/09/16
 * Time: 10:28
 */

namespace Topix\Hackademy\ContactToolSdk\Contact\Classes;


use Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable;

class RefarableTools
{
    /* Local Entities Methods*/

    // Create Local Reference
    /**
     *
     * Crea una entry sulla tabella di riferimenti per collegare l'entità referable con un id esterno.
     *
     * @param iReferable $referable
     * @param $id
     * @param $name
     * @return mixed
     */
    public static function createLocalReference(iReferable $referable, $id, $name){

        return $referable->references()->create( [
            'external_id' => $id,
            'external_entity_name' => $name
        ]);

    }


    public static function hasLocalReference(iReferable $referable)
    {
        return $referable->references()->exists();
    }

    public static function getLocalReference(iReferable $referable)
    {
        return $referable->references()->get();
    }
}