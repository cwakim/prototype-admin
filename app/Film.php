<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Film  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'films';

}
