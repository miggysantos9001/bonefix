<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Receipt;
use DB;
use Auth;
use Location;

class ReceiptController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Receipt::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Receipt::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.receipts.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:receipts',
        ],
        [
            'name.required'      =>  'Receipt Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Receipt::create(Request::all());
        Alert::success('Success', 'Receipt Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $receipt = Receipt::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:receipts,name,$receipt->id,id",
        ],
        [
            'name.required'      =>  'Receipt Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $receipt->update(Request::all());
        Alert::success('Success', 'Receipt Updated Successfully');
        return redirect()->back();
    }
}
