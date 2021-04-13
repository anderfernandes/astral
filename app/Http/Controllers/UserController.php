<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{ Validator };

class UserController extends Controller
{
    /**
     * Register a user into the system and creates an account.
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstname" => ["required", "min:2", "max:32"],
            "lastname"  => ["required", "min:2", "max:32"],
            "phone"     => ["required", "unique:users", "size:14", "confirmed"],
            "password"  => ["required", "min:6", "confirmed"],
            "email"     => ["required", "unique:users", "email", "confirmed"],
            "address"   => ["required", "min:2", "max:64"],
            "city"      => ["required", "min:2", "max:16"],
            "state"     => ["required", "min:2", "max:32"],
            "zip"       => ["required", "size:5"],
        ]);
    
    }

    /**
     * Takes user email and sends an email with a link to reset password
     *
     * @param Request $request
     * @return void
     */
    public function forgot(Request $request)
    {

    }

    /**
     * Changes user password
     *
     * @param Request $request
     * @return void
     */
    public function reset(Request $request)
    {

    }

    /**
     * Signs user into the system
     *
     * @param Request $request
     * @return void
     */
    public function signin(Request $request)
    {
        
    }
}
