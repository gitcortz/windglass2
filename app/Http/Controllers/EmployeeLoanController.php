<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeLoan;
use App\Models\Enums\LoanStatus;
use Datatables;
use Validator;

class EmployeeLoanController extends Controller
{
    public function index(){ 
        return view("home.views.employeeloans");
    }

    public function list() {
        $employee_loans = EmployeeLoan::with('employee')->select('employee_loans.*');
        return Datatables::of($employee_loans)
                ->addColumn('employeename', function (EmployeeLoan $loan) {
                    return $loan->employee ? $loan->employee->first_name." ".$loan->employee->last_name : '';
                })
                ->addColumn('loanstatus', function (EmployeeLoan $loan) {
                    return $loan->loan_status();
                })
                ->addColumn('loantype', function (EmployeeLoan $loan) {
                    return $loan->loan_type();
                })
                ->addColumn("action_btns", function($employee_loans) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$employee_loans->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$employee_loans->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'employee_id' => 'required',
            'loan_amount' => 'required',          
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = EmployeeLoan::create([
            'employee_id' => $request->employee_id,
            'loan_amount' => $request->loan_amount, 
            'balance' => $request->loan_amount, 
            'loan_type_id' => $request->loan_type_id,
            'loan_status_id' => LoanStatus::ForApproval
          ]);


        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = EmployeeLoan::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'employee_id' => 'required',
            'loan_amount' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = EmployeeLoan::find($id);
        $data->employee_id =  $request->input('employee_id');
        $data->loan_amount =  $request->input('loan_amount');
        $data->loan_type_id = $request->input('loan_type_id');
        $data->loan_status_id = $request->input('loan_status_id');

        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $data = EmployeeLoan::destroy($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    
}

