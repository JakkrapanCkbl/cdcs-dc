<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {     
        
        $incomings = DB::table('vwShowGrid')
            ->where('ClassID','=','I')
            ->where('ShowContract','=','02')
            ->where('RegisterID','not like','%IB%')
            ->orderBy('IssuedDate', 'DESC')
            ->paginate(20);
        $incomings->appends($request->all());  //for paginate use
        
        $outgoings  = DB::table('vwShowGridOut')
            ->where('ClassID','=','O')
            ->where('ShowContract','=','02')
            ->where('RegisterID','not like','%OB%')
            ->orderBy('IssuedDate', 'DESC')
            ->paginate(20);
        $outgoings->appends($request->all()); //for paginate use

        return view('home',['incomings'=>$incomings, 'outgoings'=>$outgoings]);
    }

    
}
