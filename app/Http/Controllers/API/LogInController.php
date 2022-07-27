<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class LogInController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)) {
            $success = true;
            $message = "Successfully logged in";
        } else {
            $success = false;
            $message = "Credentials not found!";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function register(Request $request){
        try{
            $dup_name= $this->check_duplicate_name($request->name);
            $dup_mail = $this->check_duplicate_email($request->email);
            if($dup_name){
                $success = false;
                $message = "Duplicate name!!";
            }else if($dup_mail){
                $success = false;
                $message = "Duplicate email!!";
            }else{
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->pass_con = Hash::make($request->pass_con);
                $user->role_id='2';
                $user->save();
                $success = true;
                $message = "User registered successfully";
            }
            
        }catch(\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function logout()
    {
        try{
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        }catch(\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function check_duplicate_name($name){
        $dup = false;
        $cc =DB::table('users')
            ->where('users.name','=',$name)
            ->count();
        if($cc>0){
            $dup=true;
        }
        return $dup;
    }
    public function check_duplicate_email($email){
        $dup = false;
        $cc =DB::table('users')
            ->where('users.email','=',$email)
            ->count();
        if($cc>0){
            $dup=true;
        }
        return $dup;
    }
}
