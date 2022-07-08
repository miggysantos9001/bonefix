<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $connection = 'mysql';
    protected $table = 'hospitals';

    protected $guarded = [];

    public function branch(){
        return $this->belongsTo('App\Branch','branch_id','id');
    }

    public function regional(){
        return $this->belongsTo('App\Region','region','id');
    }
}
