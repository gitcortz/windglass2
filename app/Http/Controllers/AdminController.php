<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use App\Models\Branch;
use App\Models\UserBranches;

class AdminController extends Controller
{
    public function adminLoginForm() {


        if (session("is_active") == 1) {
            return redirect("/");
        } else {
            $branches = Branch::all();

            return view("home.views.login_form", ['allBranches' => $branches]);
        }
    }

    public function checkUserLogin(Request $request) {
        $validator = Validator::make($request->input(), array(
            'email' => 'required',
            'password' => 'required',
            'branch' => 'required'
        ));

        if ($validator->fails()) {
            return redirect("login")->withErrors($validator)->withInput();
        }

        $user_info = array(
            "email" => $request->email,
            "password" => $request->password,            
        );
        $branch_id = $request->branch;
        
        
        if (auth()->guard("web")->attempt($user_info)) {
            $logged_user_details = auth()->guard("web")->user();
            if ($this->isUserHasBranch($logged_user_details->id, $branch_id)) {
                session(["is_active" => 1]);
                session(["user_details" => $logged_user_details]);
                session(["branch_id" => $branch_id]);                
                session(["branch_name" => Branch::find($branch_id)->name]);
                return redirect("/");
            }
            else {
                return redirect()->back()->withErrors("user not allowed");
            }
        } else {
            $error_message = "Invalid credentials";
            return redirect()->back()->withErrors($error_message);
        }

    }

    public function set_branch($branch_id) {
        $valid = true;        
        if ($this->isUserHasBranch(session("user_details")->id, $branch_id)) {
            session(["branch_id" => $branch_id]);                
            session(["branch_name" => Branch::find($branch_id)->name]);
        }
        else {
            $valid = false;
        }

        return response()->json([
            'error' => false,
            'result'  => $valid,
        ], 200);
    }

    private function isUserHasBranch($user_id, $branch_id) {
        $branches = UserBranches::where('user_id', $user_id)
                    ->where('branch_id', $branch_id)
                    ->get();
        return !$branches->isEmpty();
    }

    public function logout() {
        Session::flush();
        Auth::guard("web")->logout();
        return redirect("/login");
    }
}
