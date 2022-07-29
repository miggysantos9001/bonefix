<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Payment_type;
use DB;
use Auth;
use Location;

class PaymentTypeController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Payment_type::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Payment_type::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.payment-types.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:payment_types',
        ],
        [
            'name.required'      =>  'Payment Type Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Payment_type::create(Request::all());
        Alert::success('Success', 'Payment Type Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $pt = Payment_type::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:payment_types,name,$pt->id,id",
        ],
        [
            'name.required'      =>  'Payment Type Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pt->update(Request::all());
        Alert::success('Success', 'Payment Type Updated Successfully');
        return redirect()->back();
    }
}
