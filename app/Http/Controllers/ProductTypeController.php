<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;
use Datatables;
use Validator;

class ProductTypeController extends Controller
{
    public function index(){ 
        return view("home.views.producttypes");
    }

    public function list() {
        $productTypes = ProductType::query();
        return Datatables::of($productTypes)
                ->addColumn("action_btns", function($productTypes) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$productTypes->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$productTypes->id.'">Delete</a>';
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

        $data = ProductType::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = ProductType::find($id);

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

        $data = ProductType::find($id);
        $data->name =  $request->input('name');
      
        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = ProductType::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}
