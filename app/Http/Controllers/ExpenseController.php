<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Datatables;
use Validator;
use \Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(){ 
        return view("home.views.expenses");
    }
    
    public function list(Request $request) {
        $matchThese = [];
        if($request->branch_id)
            $matchThese['branch_id'] = $request->branch_id;

        $expenses = Expense::where($matchThese);

        $keyword = $request->query('search_keyword');        
        if($keyword){
            $expenses = $expenses
            ->where('id', '=', $keyword)
            ->orWhere('payee', 'LIKE', "%{$keyword}%")
            ->orWhere('particulars', 'LIKE', "%{$keyword}%");
        }      
        
        return Datatables::of($expenses)
                ->addColumn("action_btns", function($expenses) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$expenses->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$expenses->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'payee' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Expense::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Expense::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'payee' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Expense::find($id);
        $data->payee =  $request->input('payee');
        $data->particulars =  $request->input('particulars');
        $data->expense_date =  $request->input('expense_date');
        $data->amount =  $request->input('amount');
        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Expense::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}
