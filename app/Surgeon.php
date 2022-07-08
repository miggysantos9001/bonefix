<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surgeon extends Model
{
    protected $connection = 'mysql';
    protected $table = 'surgeons';

    protected $guarded = [];

    public function branch(){
        return $this->belongsTo('App\Branch','branch_id','id');
    }
}
