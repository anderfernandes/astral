<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function authenticate(Request $request) {

      $credentials = $request->only("email", "password");
      $credentials["active"] = "1";

      if (Auth::attempt($credentials))
        return redirect()->intended("admin");
      else
        return redirect()->back()
                         ->withInput()
                         ->withErrors(["email" => "Invalid credentials."]);

    }

    public function login() {

      return view("auth.login");

    }

    public function logout()
    {
      
      Auth::logout();
      
      return redirect()->intended("home");

    }
}