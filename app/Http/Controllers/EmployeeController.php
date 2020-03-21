<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeLoan;
use App\Models\EmployeeLoanTransaction;
use App\Models\Enums\LoanStatus;
use App\Models\Enums\LoanTransactionType;
use App\Http\Resources\EmployeeComboResource;
use App\Http\Resources\EmployeeComboCollection;
use Datatables;
use Validator;

class EmployeeController extends Controller
{
    public function index(){ 
        return view("home.views.employees");
    }

    public function list() {
        $employees = Employee::with('employeetype')->select('employees.*');
        return Datatables::of($employees)
                ->addColumn('employeetype', function (Employee $employee) {
                    return $employee->employeetype ? $employee->employeetype->name : '';
                })
                ->addColumn("action_btns", function($employees) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$employees->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$employees->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function combo_list() {
        return new EmployeeComboCollection(Employee::get());
    }

    public function riders() {
        $riders = Employee::with('employeetype')
        ->whereHas('employeetype', function($query) {
            $query->where('name', 'rider');
        })->get();
        
        return new EmployeeComboCollection($riders);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'first_name' => 'required',
            'last_name' => 'required',          
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Employee::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Employee::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'first_name' => 'required',
            'last_name' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Employee::find($id);
        $data->first_name =  $request->input('first_name');
        $data->last_name =  $request->input('last_name');
        $data->email = $request->input('email');
        $data->address = $request->input('address');
        $data->city_id = $request->input('city_id');
        $data->phone = $request->input('phone');
        $data->mobile = $request->input('mobile');
        $data->notes = $request->input('notes');
        $data->base_salary = $request->input('base_salary');        
        $data->biometrics_id = $request->input('biometrics_id');
        $data->employeetype_id = $request->input('employeetype_id');
        $data->hire_date = $request->input('hire_date');

        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $data = Employee::destroy($id);

        return response()->json([
            'error' => false,
            'employee'  => $data,
        ], 200);
    }

    public function loans(Request $request)
    {
        $employee_id = $request->id;
        //$loans = EmployeeLoan::with('employee')->where('employee_id', $employee_id)->get();
        //return ($loans);
        
        $employee_loans = EmployeeLoan::with('employee')->where('employee_id', $employee_id)->select('employee_loans.*');
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
                    return 
                    ($employee_loans->loan_status_id != LoanStatus::ForApproval ? '' :
                        '<a href="#" class="btn btn-success" action="approve" data-id="'.$employee_loans->id.'">Approve</a>')
                    .($employee_loans->loan_status_id != LoanStatus::ForApproval ? '' :
                        '&nbsp;<a href="#" class="btn btn-info" action="edit" data-id="'.$employee_loans->id.'">Edit</a>')
                    .($employee_loans->loan_status_id != LoanStatus::ForApproval ? '' : 
                        '&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$employee_loans->id.'">Delete</a>');
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    
}
