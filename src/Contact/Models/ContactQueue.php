<?php

namespace Topix\Hackademy\ContactToolSdk\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQueue Extends Model
{
    protected $fillable = array('entity', 'method', 'payload');
}