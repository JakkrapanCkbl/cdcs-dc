<?php

namespace App\Http\Controllers\Drawing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrawingController extends Controller
{
    function check(Request $request){
        // $request->validate([
        //     'loginname'=>'required|loginname|exists:users,loginname',
        //     'password'=>'required'
        // ]);

        $creds = $request->only('loginname','password');

        if(Auth::guard('drawing')->attempt($creds)) {
            return redirect()->route('drawing.home');
        }else{
            return redirect()->route('drawing.login')->with('fail','Incorrect Credentials');
        }
    }

    function logout(){
        Auth::guard('drawing')->logout();
        return redirect('/');
    }
}
