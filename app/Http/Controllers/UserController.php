<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserBranches;
use Datatables;
use Validator;
use Hash;
use DB;

class UserController extends Controller
{
    /*
        public function __construct() {
            $this->middleware(['auth', 'clearance']);//->except('index', 'show');
        }
    
      public function __construct() {
            $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
        }
    */
    public function index(){ 
        return view("home.views.users");
    }

    public function list() {
        $users = User::query();
        return Datatables::of($users)
                ->addColumn("action_btns", function($users) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$users->id.'">Edit</a>'
                    .($users->id == 1 ? '' : '&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$users->id.'">Delete</a>');
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'name' => 'required',     
            'email'=> 'required|unique:users,email,'.$id,
            'password'=>'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $user_info = array(
            "name" => $request->name,
            "email" => $request->email,
            "password" =>  $password = Hash::make($request->password),
            "active" => $request->active == "on" ? true : false
        );

        $data = User::create($user_info);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = User::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'name' => 'required',
            'email'=> 'required|unique:users,email,'.$id,
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = User::find($id);
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->active = $request->input('active') == "on" ? true : false;
        if ($request->input('password'))
            $data->password =Hash::make($request->input('password'));

        //$data->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $data->assignRole($request->role);

        if ($request->branch) {
            UserBranches::where('user_id', $id)->delete();
            $userbranches = [];
            foreach ($request->branch as $branch=>$value) {
                $userbranch = new UserBranches();
                $userbranch->user_id = $id;
                $userbranch->branch_id = $value;
                $userbranch->created_at = date('Y-m-d H:i:s');
                $userbranch->updated_at = date('Y-m-d H:i:s');
                $userbranches[] = $userbranch->attributesToArray();
            }
          //  UserBranches::insert($userbranches);
        }


        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = User::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function branches(Request $request)
    {
        $user_id = $request->id;
        $branches = UserBranches::where('user_id', $user_id)->get();
        return ($branches);
    }
}
