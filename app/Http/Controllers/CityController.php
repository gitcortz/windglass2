<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Datatables;
use Validator;

class CityController extends Controller
{
    public function index(){ 
        return view("home.views.cities");
    }

    public function list() {
        $cities = City::query();
        return Datatables::of($cities)
                ->addColumn("action_btns", function($cities) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$cities->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$cities->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'name' => 'required',            
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = City::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = City::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'name' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $customer = City::find($id);
        $customer->name =  $request->input('name');
      
        $customer->save();

        return response()->json([
            'error' => false,
            'data'  => $customer,
        ], 200);
    }

    public function destroy($id)
    {
        $task = City::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}