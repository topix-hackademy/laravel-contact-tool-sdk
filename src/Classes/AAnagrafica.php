<?php
namespace Topix\Hackademy\ContactToolSdk\Classes;

abstract class AAnagrafica {

    protected $api;
    protected $entity = '';

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function all(){
        return $this->api->get($this->entity);
    }
    public function get($id){
        return $this->api->get($this->entity.'/'.$id.'/');
    }
    public function create(Array $data){
        return $this->api->post($this->entity.'/', $data);
    }
    public function update($id, Array $data){
        return $this->api->put($this->entity.'/'.$id.'/', $data);
    }
    public function delete($id){
        return $this->api->delete($this->entity.'/'.$id);
    }

}
