<?php

namespace App\Http\Controllers\Drawing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function index(Request $request){     
        $strsql = "SELECT * FROM vwDwgReg_List_Step2_Short ";
        $strsql = $strsql . "WHERE (ShowContract like 'DC2') ";
        $strsql = $strsql . "AND (substring(dwg_no,5,4) like '%') ";
        $strsql = $strsql . "AND (Status like 'W') ";
        $strsql = $strsql . "AND (DwgCancel = 0) ";
        $drawings = DB::select($strsql);
        // DB::table('vwDwgReg_List_Step2_Short')
        // ->where('ShowContract','=','DC2')
        // ->where('Status','=','0')
        // ->orderBy('Status', 'Dwg_no', 'Revision')
        // ->get();

        return view('drawing.home',['drawings'=>$drawings, 'options'=>'1']);
    }


}
