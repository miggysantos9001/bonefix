<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Branch;
use App\Hospital;
use App\Region;
use DB;
use Auth;
use Location;

class HospitalController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Hospital::query()->with('branch','regional')->select('id','branch_id','region','name','code','address','rate','office','km')
                ->where('name','LIKE',"%{$searchName}%")
                ->orWhere('code','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Hospital::query()->with('branch','regional')->select('id','branch_id','region','name','code','address','rate','office','km')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        $branches = Branch::pluck('name','id');
        $regions = Region::orderBy('id')->get()->pluck('name','id');
        return view('admin.hospitals.index',compact('data','branches','regions'));
    }

    public function store(){
    	$validator = Validator::make(Request::all(), [
    		'branch_id'					=>	'required',
		    'name'						=>	'required|unique:hospitals',
		    'code'						=>	'required|unique:hospitals',
		],
		[
			'branch_id.required'		=>	'Please Select Branch',
		    'name.required'     		=>	'Hospital Name Required',
		    'code.required'     		=>	'Hospital Code Required',
		]);

		if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = Request::except('region');

        if(Request::get('region') == 1){
            $region = 1;
        }else{
            $region = 0;
        }

        $data = Arr::add($data,'region',$region);
		Hospital::create($data);

		Alert::success('Success', 'Hospital Created Successfully');
    	return redirect()->back();
    }

    public function update($id){
		$hospital = Hospital::find($id);
		$validator = Validator::make(Request::all(), [
			'branch_id'					=>	'required',
		    'name'						=>	"required|unique:hospitals,name,$hospital->id,id",
		    'code'						=>	"required|unique:hospitals,code,$hospital->id,id",
		],
		[
			'branch_id.required'		=>	'Please Select Branch',
		    'name.required'     		=>	'Hospital Name Required',
		    'code.required'     		=>	'Hospital Code Required',
		]);


		if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = Request::except('region');

        if(Request::get('region') == 1){
            $region = 1;
        }else{
            $region = 0;
        }

        $data = Arr::add($data,'region',$region);
		$hospital->update($data);

		Alert::success('Success', 'Hospital Updated Successfully');
    	return redirect()->back();
    }
}
