<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Datatables;

class CustomerController extends Controller
{
    public function index(){
        return view("home.views.customers");
    }

    public function list() {
        // $tasks = Task::orderBy('id', 'desc')->paginate(5);

        $customers = Customer::query();
        return Datatables::of($customers)
                ->editColumn("action_btns", function($customers) {
                    return '<a href="#" class="btn btn-info customer-edit" data-id="'.$customers->id.'">Edit</a>'
                    .'<a href="#" class="btn btn-danger customer-delete" data-id="'.$customers->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'task' => 'required',
            'description' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $task = Task::create($request->all());

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function show($id)
    {
        $task = Task::find($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'task' => 'required',
            'description' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $task = Task::find($id);

        $task->task        =  $request->input('task');
        $task->description = $request->input('description');

        $task->save();

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}
