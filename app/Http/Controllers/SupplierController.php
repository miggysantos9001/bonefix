<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Supplier;
use DB;
use Auth;
use Location;

class SupplierController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Supplier::query()->select('id','name','address','email','contact','contact_person')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Supplier::query()->select('id','name','address','email','contact','contact_person')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.suppliers.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'                      =>  'required',
            'address'                   =>  'required',
            'email'                     =>  'required',
            'contact'                   =>  'required',
            'contact_person'            =>  'required',
        ],
        [
            'name.required'             =>  'Supplier Name Required',
            'address.required'          =>  'Supplier Address Required',
            'email.required'            =>  'Supplier Email Required',
            'contact.required'          =>  'Supplier Contact # Required',
            'contact_person.required'   =>  'Supplier Contact Person Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Supplier::create(Request::all());

        Alert::success('Success', 'Supplier Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $supplier = Supplier::find($id);
        $validator = Validator::make(Request::all(), [
            'name'                      =>  'required',
            'address'                   =>  'required',
            'email'                     =>  'required',
            'contact'                   =>  'required',
            'contact_person'            =>  'required',
        ],
        [
            'name.required'             =>  'Supplier Name Required',
            'address.required'          =>  'Supplier Address Required',
            'email.required'            =>  'Supplier Email Required',
            'contact.required'          =>  'Supplier Contact # Required',
            'contact_person.required'   =>  'Supplier Contact Person Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $supplier->update(Request::all());

        Alert::success('Success', 'Supplier Updated Successfully');
        return redirect()->back();
    }
}
