<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tech_category extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tech_categories';

    protected $guarded = [];
}
