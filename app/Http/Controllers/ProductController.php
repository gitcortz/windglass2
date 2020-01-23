<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Datatables;
use Validator;

class ProductController extends Controller
{
    public function index(){ 
        return view("home.views.products");
    }

    public function list() {
        $products = Product::with('producttype', 'brand')->select('products.*');;
        return Datatables::of($products)
                ->addColumn('producttype', function (Product $product) {
                    return $product->producttype ? $product->producttype->name : '';
                })
                ->addColumn('brand', function (Product $product) {
                    return $product->brand ? $product->brand->name : '';
                })
                ->addColumn("action_btns", function($products) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$products->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$products->id.'">Delete</a>';
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

        $data = Product::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Product::find($id);

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

        $data = Product::find($id);
        $data->name =  $request->input('name');
        $data->description = $request->input('description');
        $data->producttype_id = $request->input('producttype_id');
        $data->brand_id = $request->input('brand_id');
        $data->unit_price = $request->input('unit_price');

        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Product::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}

