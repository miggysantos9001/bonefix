<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $connection = 'mysql';
    protected $table = 'regions';

    protected $guarded = [];
}
