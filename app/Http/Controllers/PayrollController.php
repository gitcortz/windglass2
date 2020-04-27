<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\Payroll\PayrollServiceInterface;
use App\Models\Payroll;
use Datatables;
use Validator;
use Excel;

class PayrollController extends Controller
{
    public function index(){ 
        return view("home.views.payrolls");
    }

    public function list(Request $request) {

        $payrolls = Payroll::where('year', $request->query('year'))
                    ->where('week_no', $request->query('weekno'))
                    ->get();

        return Datatables::of($payrolls)
                ->addColumn('employeename', function (Payroll $payroll) {
                    return $payroll->employee ? $payroll->employee->first_name." ".$payroll->employee->last_name : '';
                })
                ->make(true);
    }

    public function generate(Request $request, PayrollServiceInterface $payrollServiceInstance)
    {
       
        $validator = Validator::make($request->input(), array(
            'weekno' => 'required',
            'year' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = $payrollServiceInstance->generatePayroll($request->query('year'), $request->query('weekno'));
        
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function export(Request $request, PayrollServiceInterface $payrollServiceInstance)
    {
        $validator = Validator::make($request->input(), array(
            'weekno' => 'required',
            'year' => 'required',
        ));
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }


        $payrollServiceInstance->exportPayroll($request->query('year'), $request->query('weekno'));       
    }

    public function approve(Request $request, PayrollServiceInterface $payrollServiceInstance)
    {
        $validator = Validator::make($request->input(), array(
            'weekno' => 'required',
            'year' => 'required',
        ));
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }


        $payrollServiceInstance->approvePayroll($request->query('year'), $request->query('weekno'));

        return response()->json([
            'error' => false,
            'data'  => "OK",
        ], 200);
       
    }

}
