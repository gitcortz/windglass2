<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\UserBranches;
use Datatables;
use Validator;

class BranchController extends Controller
{
    public function __construct() {
        $this->middleware('not.auth');
    }

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
    
    public function products(Request $request)
    {
        $branch_id = $request->id;
        $products = Stock::with('product.brand')->where('branch_id', $branch_id)->get();
        return ($products);
    }

    public function empty_cylinders(Request $request) {
        $branch_id = $request->id;
    
        $products = Stock::with('product.brand')
                    ->join('products', 'stocks.product_id', '=', 'products.id')
                    ->join('product_types', 'products.producttype_id', '=', 'product_types.id')
                    ->where('branch_id', $branch_id)
                    ->where('product_types.name', 'Empty Cylinders')
                    ->get(['stocks.*']);
        return ($products);
    }

    public function session(Request $request)
    {
        $user_id = session("user_details")->id;
        if (!session("user_branches")){
            $branches = UserBranches::with('branch')->where('user_id', $user_id)->get();
            session(["user_branches" => $branches]);
            if (session("user_branches")->count() > 0) {
                session(["branch_id" => session("user_branches")[0]->branch_id ]);
                session(["branch_name" => session("user_branches")[0]->branch->name]);            
            } 
        }
        
        return response()->json([
            'error' => false,
            'selected' => session("branch_id"),
            'data'  => session("user_branches"),
        ], 200);            
        
    }
}
