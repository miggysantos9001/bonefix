<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other_expense extends Model
{
    protected $connection = 'mysql';
    protected $table = 'other_expenses';

    protected $guarded = [];
}
