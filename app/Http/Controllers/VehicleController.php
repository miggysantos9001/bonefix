<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Vehicle;
use DB;
use Auth;
use Location;

class VehicleController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Vehicle::query()->select('id','name')
                ->where('name','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Vehicle::query()->select('id','name')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.vehicles.index',compact('data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'name'                      =>  'required|unique:vehicles',
        ],
        [
            'name.required'             =>  'Vehicle Name Required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Vehicle::create([
            'name'      =>      Request::get('name'),
        ]);

        Alert::success('Success', 'Vehicle Created Successfully');
        return redirect()->back();
    }

    public function update($id){
        $vehicle = Vehicle::find($id);
        $validator = Validator::make(Request::all(), [
            'name'                      =>  "required|unique:agents,name,$vehicle->id,id",
        ],
        [
            'name.required'             =>  'Vehicle Name Required',
        ]);


        if ($validator->fails()) {
            foreach($validator->errors()->all() as $error) {
                toastr()->warning($error);
            }
            return redirect()->back()
            ->withInput();
        }

        $vehicle->update([
            'name'      =>      Request::get('name'),
        ]);

        Alert::success('Success', 'Vehicle Updated Successfully');
        return redirect()->back();
    }
}
