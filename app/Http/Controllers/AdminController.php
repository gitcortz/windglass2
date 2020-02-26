<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;

class AdminController extends Controller
{
    public function adminLoginForm() {
        if (session("is_active") == 1) {
            return redirect("/");
        } else {
            return view("home.views.login_form");
        }
    }

    public function checkUserLogin(Request $request) {
        //print_r($request->all());

        $validator = Validator::make($request->input(), array(
            'email' => 'required',
            'password' => 'required',
        ));

        if ($validator->fails()) {
            return redirect("login")->withErrors($validator)->withInput();
        }

        $user_info = array(
            "email" => $request->email,
            "password" => $request->password,
        );

        if (auth()->guard("web")->attempt($user_info)) {
            $logged_user_details = auth()->guard("web")->user();
            session(["is_active" => 1]);
            session(["user_details" => $logged_user_details]);
            return redirect("/");
        } else {
            $error_message = "Invalid credentials";
            return redirect()->back()->withErrors($error_message);
        }

    }

    public function logout() {
        Session::flush();
        Auth::guard("web")->logout();
        return redirect("/login");
    }
}
