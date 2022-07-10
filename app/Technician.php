<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $connection = 'mysql';
    protected $table = 'technicians';

    protected $guarded = [];

    public function tech_cat(){
        return $this->belongsTo('App\Tech_category','tech_category_id','id');
    }
}
