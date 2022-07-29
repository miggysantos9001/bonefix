<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Cer_name;
use DB;
use Auth;
use Location;

class ExpenseReportController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Cer_name::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Cer_name::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.expense-report-entries.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:cer_names',
        ],
        [
            'name.required'      =>  'Expense Report Entry Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Cer_name::create(Request::all());
        Alert::success('Success', 'Expense Report Entry Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $cer = Cer_name::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:cer_names,name,$cer->id,id",
        ],
        [
            'name.required'      =>  'Expense Report Entry Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cer->update(Request::all());
        Alert::success('Success', 'Expense Report Entry Updated Successfully');
        return redirect()->back();
    }
}
