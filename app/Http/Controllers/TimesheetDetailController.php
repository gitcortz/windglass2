<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\TimesheetDetail;
use App\Models\Employee;
use Datatables;
use Validator;

class TimesheetDetailController extends Controller
{
    public function index(){ 
        return view("home.views.timesheetdetails");
    }

    public function list() {
        $timesheetDetails = TimesheetDetail::with('employee')->select('timesheet_details.*');;
        return Datatables::of($timesheetDetails)
            ->addColumn('employeename', function (TimesheetDetail $timesheetDetail) {
                return $timesheetDetail->employee ? $timesheetDetail->employee->first_name." ".$timesheetDetail->employee->last_name : '';
            })
            ->addColumn('hours', function (TimesheetDetail $timesheetDetail) {
                return $timesheetDetail->total_hours();
            })
            ->addColumn("action_btns", function($timesheetDetails) {
                return '<a href="#" class="btn btn-info" action="edit" data-id="'.$timesheetDetails->id.'">Edit</a>'
                .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$timesheetDetails->id.'">Delete</a>';
            })
            ->rawColumns(["action_btns"])
            ->make(true);
            
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'employee_id' => 'required',   
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = TimesheetDetail::create([
            'employee_id' => $request->employee_id,
            'time_in' => $request->time_in, 
            'time_out' => $request->time_out, 
          ]);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = TimesheetDetail::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'employee_id' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = TimesheetDetail::find($id);
        $data->employee_id =  $request->input('employee_id');
        $data->time_in = $request->input('time_in');
        $data->time_out = $request->input('time_out');
      
        //$data->time_in = date("Y-m-d H:i:s",strtotime($request->input('time_in')));
        //$data->time_out = date("Y-m-d H:i:s",strtotime($request->input('time_out')));
      
        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = TimesheetDetail::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function upload(Request $request)
    {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
            'select_file' => 'required|max:2048'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validation->errors(),
            ], 422);
        }

        $path = $request->file('select_file')->move(public_path());
        $data = array_map('str_getcsv', file($path));
        $this->processCsvData($data);

        return response()->json([
            'error' => false,
            'data'  => "hooray",
        ], 200);
    }

    public function processCsvData($data) {
        $employee_index = 0;// config('app.upload_employee_index');
        $date_index = 2;//config('app.upload_date_index');
      
        $array = [];
        foreach ($data as $row) {
            if (is_numeric($row[$employee_index])) {
                $date_string = str_replace('/', '-', $row[$date_index]);
                $date_format = date("Ymd",strtotime($date_string));
                $index_name = $date_format."_".$row[$employee_index];
                if (Arr::exists($array, $index_name)) {
                    $array[$index_name]->time_out = date("Y-m-d H:i:s",strtotime($date_string));
                    
                }
                else {
                    $timesheet_detail = new TimesheetDetail();
                    $employees = Employee::where('biometrics_id', $row[$employee_index])->get();
                    if ($employees->count() > 0) {
                      $timesheet_detail->employee_id = $employees->first()->id;
                      $timesheet_detail->time_in =date("Y-m-d H:i:s",strtotime($date_string));
                      $timesheet_detail->created_at = date('Y-m-d H:i:s');
                      $timesheet_detail->updated_at = date('Y-m-d H:i:s');
                      $array[$index_name] = $timesheet_detail;                      
                   }
                }
            }            
        }
        
        $array_timesshet = [];
        foreach ($array as $key => $value) {
           $array_timesshet[] = $value->attributesToArray();
        }

        //dd($array_timesshet);
        TimesheetDetail::insert($array_timesshet);
      
    }
}
