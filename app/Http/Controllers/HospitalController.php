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
}
