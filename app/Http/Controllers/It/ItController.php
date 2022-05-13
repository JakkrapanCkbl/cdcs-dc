<?php

namespace App\Http\Controllers\It;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;


class ItController extends Controller
{
    function check(Request $request){
        // $request->validate([
        //     'loginname'=>'required|loginname|exists:users,loginname',
        //     'password'=>'required'
        // ]);

        $creds = $request->only('loginname','password');

        if(Auth::guard('it')->attempt($creds)) {
            return redirect()->route('it.home');
        }else{
            return redirect()->route('it.login')->with('fail','Incorrect Credentials');
        }
    }

    function logout(){
        // dd('ok');
        Auth::guard('it')->logout();
        return redirect('/');
    }

}
