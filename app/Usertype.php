<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    protected $connection = 'mysql';
    protected $table = 'usertypes';

    protected $guarded = [];
}
