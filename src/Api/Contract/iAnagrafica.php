<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Contract;

interface iAnagrafica
{
    public static function all();
    public static function get($id);
    public static function create(Array $data);
    public static function update($id, Array $data);
    public static function delete($id, Array $data);
}