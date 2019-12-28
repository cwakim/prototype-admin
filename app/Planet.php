<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Planet  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'planets';

}
