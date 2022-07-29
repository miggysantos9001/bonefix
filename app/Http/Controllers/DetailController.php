<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Detail;
use DB;
use Auth;
use Location;

class DetailController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Detail::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Detail::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.details.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:details',
        ],
        [
            'name.required'      =>  'Detail Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Detail::create(Request::all());
        Alert::success('Success', 'Detail Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $detail = Detail::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:details,name,$detail->id,id",
        ],
        [
            'name.required'      =>  'Detail Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $detail->update(Request::all());
        Alert::success('Success', 'Detail Updated Successfully');
        return redirect()->back();
    }
}
