<?php

namespace Topix\Hackademy\ContactToolSdk\Test;

use Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable;
use Topix\Hackademy\ContactToolSdk\Contact\Traits\Referable;
use Illuminate\Database\Eloquent\Model;


class User extends Model implements iReferable
{

    use  Referable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','uid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
