<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Branch;
use DB;
use Auth;
use Location;

class BranchController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Branch::query()->select('id','name','code')
                ->where('name','LIKE',"%{$searchName}%")
                ->orWhere('code','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Branch::query()->select('id','name','code')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.branches.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required',
            'code'               =>  'required|unique:branches',
        ],
        [
            'name.required'      =>  'Branch Name Required',
            'code.required'      =>  'Branch Code Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Branch::create(Request::all());
        Alert::success('Success', 'Branch Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $branch = Branch::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required',
            'code'               =>  "required|unique:branches,code,$branch->id,id",
        ],
        [
            'name.required'      =>  'Branch Name Required',
            'code.required'      =>  'Branch Code Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $branch->update(Request::all());
        Alert::success('Success', 'Branch Updated Successfully');
        return redirect()->back();
    }
}
