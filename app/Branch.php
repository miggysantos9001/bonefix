<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $connection = 'mysql';
    protected $table = 'branches';

    protected $guarded = [];
}
