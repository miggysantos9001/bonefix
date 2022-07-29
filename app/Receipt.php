<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $connection = 'mysql';
    protected $table = 'receipts';

    protected $guarded = [];
}
