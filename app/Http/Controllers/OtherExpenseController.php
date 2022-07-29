<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Other_expense;
use DB;
use Auth;
use Location;


class OtherExpenseController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Other_expense::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Other_expense::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.other-expenses.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'               =>  'required|unique:other_expenses',
        ],
        [
            'name.required'      =>  'Other Expense Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Other_expense::create(Request::all());
        Alert::success('Success', 'Other Expense Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $oe = Other_expense::find($id);
        $validator = Validator::make(Request::all(), [
            'name'               =>  "required|unique:other_expenses,name,$oe->id,id",
        ],
        [
            'name.required'      =>  'Other Expense Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oe->update(Request::all());
        Alert::success('Success', 'Other Expense Entry Updated Successfully');
        return redirect()->back();
    }
}
