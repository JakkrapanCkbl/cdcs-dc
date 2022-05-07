<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function search(Request $request) {
        // if(isset($_GET['inputText']) && strlen($_GET['inputText']) > 2) {
        // dd($request->get('inputContract') . 'xx' ); 

        $ct = $request->get('inputContract'); 
        $input = $request->get('inputText');
        if ($ct == 'All') {
            $ct = '%';
        }
        $sf = $request->get('inputField');
        if ($sf=='Subject') {
            $sf = 'DocSubject';
        }
        
        if(isset($_GET['inputText'])) {
            $search_text = $_GET['inputText'];
            $incomings = DB::table('vwShowGrid')
                ->where('ClassID','=','I')
                ->where('RegisterID','not like','%IB%')
                ->where('ShowContract', 'like','%'.$ct.'%')
                ->where(function($query) use ($sf, $search_text){
                    $query->where($sf,'like','%'.$search_text.'%');
                })
                ->orderBy('IssuedDate', 'DESC')
                ->paginate(10);
            // $incomings->appends($request->all());
            
            $outgoings  = DB::table('vwShowGridOut')
                ->where('ClassID','=','O')
                ->where('RegisterID','not like','%OB%')
                ->where('ShowContract', 'like','%'.$ct.'%')
                ->where(function($query) use ($sf, $search_text){
                    $query->where($sf,'like','%'.$search_text.'%');
                })
                ->orderBy('IssuedDate', 'DESC')
                ->paginate(10);
            // $outgoings->appends($request->all());
            
            return view('home',['incomings'=>$incomings, 'outgoings'=>$outgoings, 'ct'=>$ct, 'sf'=>$sf, 'inputs'=>$input]);
        }
    }
}
