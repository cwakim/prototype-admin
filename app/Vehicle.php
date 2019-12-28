<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Vehicle  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'vehicles';

}
