<?php

namespace Topix\Hackademy\ContactToolSdk\Test;

use Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable;
use Topix\Hackademy\ContactToolSdk\Contact\Traits\Referable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model implements iReferable
{
    use Referable;
}
