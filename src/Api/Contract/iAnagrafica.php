<?php
namespace Topix\Hackademy\ContactToolSdk\Api\Contract;

interface iAnagrafica
{
    public function all();
    public function get($id);
    public function create(Array $data);
    public function update($id, Array $data);
    public function delete($id, Array $data);
}