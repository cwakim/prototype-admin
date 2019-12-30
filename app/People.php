<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class People  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'people';

}
