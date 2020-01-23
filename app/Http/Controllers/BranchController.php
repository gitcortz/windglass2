<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Datatables;
use Validator;

class BranchController extends Controller
{
    public function index(){ 
        return view("home.views.branches");
    }

    public function list() {
        $branches = Branch::with('city')->select('branches.*');;
        return Datatables::of($branches)
                ->addColumn('city', function (Branch $branch) {
                    return $branch->city ? $branch->city->name : '';
                })
                ->addColumn("action_btns", function($branches) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$branches->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$branches->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'code' => 'required',
            'name' => 'required',            
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Branch::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Branch::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'code' => 'required',
            'name' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $branch = Branch::find($id);
        $branch->code =  $request->input('code');
        $branch->name =  $request->input('name');
        $branch->email = $request->input('email');
        $branch->address = $request->input('address');
        $branch->phone = $request->input('phone');
        $branch->mobile = $request->input('mobile');
        $branch->city_id = $request->input('city_id');

        $branch->save();

        return response()->json([
            'error' => false,
            'data'  => $branch,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Branch::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}
