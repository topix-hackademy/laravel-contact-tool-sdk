<?php
namespace Topix\Hackademy\ContactToolSdk\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'external_id',
        'external_entity_name',
        'referable_id',
        'referable_type'
    ];

    public function referable (){
        return $this->morphTo();
    }

}