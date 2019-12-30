<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Starship  extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'starships';

}
