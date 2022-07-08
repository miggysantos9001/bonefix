<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $connection = 'mysql';
    protected $table = 'suppliers';

    protected $guarded = [];
}
