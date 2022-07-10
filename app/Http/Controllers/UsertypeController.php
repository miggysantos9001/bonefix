<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Usertype;
use DB;
use Auth;
use Location;

class UsertypeController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Usertype::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Usertype::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.usertypes.index',compact('data'));
    }

    public function store(){
    	$validator = Validator::make(Request::all(), [
            'name'			=> 		'required|unique:usertypes',
        ],
        [
            'name.required'		=> 	'Usertype Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        \App\Usertype::create(Request::all());

        Alert::success('Success', 'Usertype Created Successfully');
    	return redirect()->back();
    }

    public function update($id){
    	$usertype = \App\Usertype::find($id);
    	$validator = Validator::make(Request::all(), [
            'name'			=> 		"required|unique:usertypes,name,$usertype->id,id",
        ],
        [
            'name.required'		=> 	'Usertype Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $usertype->update(Request::all());

        Alert::success('Success', 'Usertype Updated Successfully');
    	return redirect()->back();
    }
}
