<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Branch;
use App\Surgeon;
use DB;
use Auth;
use Location;

class SurgeonController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Surgeon::query()->with('branch')->select('id','name','branch_id')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Surgeon::query()->with('branch')->select('id','name','branch_id')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        $branches = Branch::pluck('name','id');
        return view('admin.surgeons.index',compact('data','branches'));
    }
}
