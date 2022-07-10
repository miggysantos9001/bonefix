<?php

namespace App\Http\Controllers;

use Validator;
use Request;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Arr;
use Alert;
use App\Agent;
use DB;
use Auth;
use Location;

class AgentController extends Controller
{
    public function index(){
        $searchName = Request::get('searchName');
        if($searchName != NULL){
            $data = Agent::query()->select('id','name','code','isTech')
                ->where('name','LIKE',"%{$searchName}%")
                ->orWhere('code','LIKE',"%{$searchName}%")
                ->orderBy('name')
                ->paginate(10);
        }else{
            $data = Agent::query()->select('id','name','code','isTech')
                ->orderBy('name')
                ->paginate(10);
        }

        $data->appends(Request::all());
        return view('admin.agents.index',compact('data'));
    }

    public function store(){
    	$validator = Validator::make(Request::all(), [
		    'name'						=>	'required|unique:agents',
		    'code'						=>	'required|unique:agents',
		],
		[
		    'name.required'     		=>	'Agent Name Required',
		    'code.required'     		=>	'Agent Code Required',
		]);

		if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		if(Request::get('isTech') == 1){
			$isTech = 1;
		}else{
			$isTech = 0;
		}

		Agent::create([
			'name'		=>		Request::get('name'),
			'code'		=>		Request::get('code'),
			'isTech'	=>		$isTech,
		]);

		Alert::success('Success', 'Agent Created Successfully');
    	return redirect()->back();
    }

    public function update($id){
		$agent = Agent::find($id);
		$validator = Validator::make(Request::all(), [
		    'name'						=>	"required|unique:agents,name,$agent->id,id",
		    'code'						=>	"required|unique:agents,code,$agent->id,id",
		],
		[
		    'name.required'     		=>	'Agent Name Required',
		    'code.required'     		=>	'Agent Code Required',
		]);


		if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		if(Request::get('isTech') == 1){
			$isTech = 1;
		}else{
			$isTech = 0;
		}

		$agent->update([
			'name'		=>		Request::get('name'),
			'code'		=>		Request::get('code'),
			'isTech'	=>		$isTech,
		]);

		Alert::success('Success', 'Agent Updated Successfully');
    	return redirect()->back();
    }
}
