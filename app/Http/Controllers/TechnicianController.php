<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;

use App\Surgeon;
use App\Tech_category;
use App\Technician;
use DB;
use Auth;
use Location;

class TechnicianController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Technician::query()->with('tech_cat')->select('id','name','code','tech_category_id')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Technician::query()->with('tech_cat')->select('id','name','code','tech_category_id')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        $cat = Tech_category::pluck('name','id');
        return view('admin.technicians.index',compact('data','cat'));
    }

    public function store(){
    	$validator = Validator::make(Request::all(), [
            'name'			=> 		'required|unique:technicians',
            'code'			=> 		'required|unique:technicians',
            'tech_category_id'  =>  'required',
        ],
        [
            'name.required'		=> 	'Technician Name Required',
            'code.required'  	=> 	'Technician Code Required',
            'tech_category_id.required'     =>  'Technician Category Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Technician::create(Request::all());

        Alert::success('Success', 'Technician Created Successfully');
    	return redirect()->back();
    }

    public function update($id){
		$technician = Technician::find($id);
    	$validator = Validator::make(Request::all(), [
            'name'			=> 		"required|unique:technicians,name,$technician->id,id",
            'code'			=> 		"required|unique:technicians,code,$technician->id,id",
            'tech_category_id'  =>  'required',
        ],
        [
            'name.required'		=> 	'Technician Name Required',
            'code.required'  	=> 	'Technician Code Required',
            'tech_category_id.required'     =>  'Technician Category Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $technician->update(Request::all());

        Alert::success('Success', 'Technician Updated Successfully');
    	return redirect()->back();
    }
}
