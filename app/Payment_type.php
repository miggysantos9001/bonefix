<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_type extends Model
{
    protected $connection = 'mysql';
    protected $table = 'payment_types';

    protected $guarded = [];
}
