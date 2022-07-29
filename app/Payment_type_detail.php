<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_type_detail extends Model
{
    protected $connection = 'mysql';
    protected $table = 'payment_type_details';

    protected $guarded = [];

    public function paymenttype(){
        return $this->belongsTo('App\Payment_type','payment_type_id','id');
    }

    public function detail(){
        return $this->belongsTo('App\Detail','details','id');
    }

    public function receipt(){
        return $this->belongsTo('App\Receipt','receipt_type','id');
    }
}
