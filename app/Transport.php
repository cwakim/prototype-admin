<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Transport  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'transport';

}
