<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Detail;
use App\Payment_type;
use App\Payment_type_detail;
use App\Receipt;
use DB;
use Auth;
use Location;

class PaymentTypeDetailController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Payment_type_detail::query()->with(['paymenttype','detail','receipt'])
                ->select('id','payment_type_id','details','receipt_type','wh','vat')
                ->where('payment_type_id',$searchName)
                ->paginate(10);
        }else{
            $data = Payment_type_detail::query()->with(['paymenttype','detail','receipt'])
                ->select('id','payment_type_id','details','receipt_type','wh','vat')
                ->paginate(10);
        }
        
        $payment_types = Payment_type::orderBy('name')->get()->pluck('name','id');
	    $details = Detail::orderBy('name')->get()->pluck('name','id');
	    $receipts = Receipt::orderBy('name')->get()->pluck('name','id');
        $data->appends(Request::all());
        return view('admin.payment-type-details.index',compact('data','details','receipts','payment_types'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
    		'payment_type_id'			=>	'required',
    		'details'					=>	'required',
    		'receipt_type'				=>	'required',
		],
		[
			'payment_type_id.required'	=>	'Please Select Payment Type',
			'details.required'			=>	'Please Select Detail',
			'receipt_type.required'		=>	'Please Select Receipt Type',
		]);

		if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Payment_type_detail::create(Request::all());
        Alert::success('Success', 'Payment Type Detail Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $ptd = Payment_type_detail::find($id);
		$validator = Validator::make(Request::all(), [
    		'payment_type_id'			=>	'required',
    		'details'					=>	'required',
    		'receipt_type'				=>	'required',
		],
		[
			'payment_type_id.required'	=>	'Please Select Payment Type',
			'details.required'			=>	'Please Select Detail',
			'receipt_type.required'		=>	'Please Select Receipt Type',
		]);

		if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $ptd->update(Request::all());
        Alert::success('Success', 'Payment Type Detail Updated Successfully');
        return redirect()->back();
    }
}
