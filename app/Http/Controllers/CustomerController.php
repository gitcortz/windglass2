<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\CustomerComboResource;
use App\Http\Resources\CustomerComboCollection;
use Illuminate\Support\Facades\DB;
use Datatables;
use Validator;

class CustomerController extends Controller
{
    public function index(){ 
        return view("home.views.customers");
    }

    public function list() {
        $customers = Customer::with('city')->select('customers.*');;
        return Datatables::of($customers)
                ->addColumn('city', function (Customer $customer) {
                    return $customer->city ? $customer->city->name : '';
                })
                ->addColumn("action_btns", function($customers) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$customers->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$customers->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function search(Request $request) {

        if($request->keyword != "") {
            $keyword = $request->keyword;
            $customers = DB::table('customers')
                ->leftJoin('cities', 'customers.city_id', '=', 'cities.id')
                ->whereNull('customers.deleted_at')
                ->where(function($q) use ($keyword){
                    $q->orWhere('customers.name', 'LIKE', '%'.$keyword.'%');
                    $q->orWhere('address', 'LIKE', '%'.$keyword.'%');
                    $q->orWhere('cities.name', 'LIKE', '%'.$keyword.'%');
                })
                ->select('customers.*', 'cities.name as city');
        }
        else { 
            $customers = DB::table('customers')
                ->leftJoin('cities', 'customers.city_id', '=', 'cities.id')
                -> whereNull('customers.deleted_at')                
                ->select('customers.*', 'cities.name as city');
        }


        return Datatables::of($customers)
                ->addColumn('contact', function ($customer) {
                    return ($customer->phone ? $customer->phone.' / ' : '').$customer->mobile;
                })               
                ->addColumn("action_btns", function($customers) {
                    return '<a href="#" class="btn btn-info btn-sm" action="select" data-id="'.$customers->id.'">Select</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);             
  
    }

    public function combo_list() {
        return new CustomerComboCollection(Customer::get());
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

        $data = Customer::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Customer::find($id);

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

        $customer = Customer::find($id);
        $customer->name =  $request->input('name');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->mobile = $request->input('mobile');
        $customer->notes = $request->input('notes');
        $customer->discount = $request->input('discount');
        $customer->city_id = $request->input('city_id');

        $customer->save();

        return response()->json([
            'error' => false,
            'data'  => $customer,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Customer::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    
}
