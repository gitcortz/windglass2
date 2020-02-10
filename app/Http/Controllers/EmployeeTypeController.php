<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeType;
use Datatables;
use Validator;

class EmployeeTypeController extends Controller
{
    public function index(){ 
        return view("home.views.employeetypes");
    }

    public function list() {
        $employeeTypes = EmployeeType::query();
        return Datatables::of($employeeTypes)
                ->addColumn("action_btns", function($employeeTypes) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$employeeTypes->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$employeeTypes->id.'">Delete</a>';
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

        $data = EmployeeType::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = EmployeeType::find($id);

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

        $data = EmployeeType::find($id);
        $data->name =  $request->input('name');
      
        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = EmployeeType::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}
