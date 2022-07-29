<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $connection = 'mysql';
    protected $table = 'details';

    protected $guarded = [];
}
