<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Specie  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'species';

}
