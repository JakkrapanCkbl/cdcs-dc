<?php

namespace App\Http\Controllers\Drawing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;


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

    public function dwg_list(Request $request)
    {     
        
        $strsql = "SELECT * FROM vwDwgReg_List_Step2_Short ";
        $strsql = $strsql . "WHERE (ShowContract like 'DC2') ";
        $strsql = $strsql . "AND (Revision = 'A') ";
        $strsql = $strsql . "AND (DwgCancel = 0) ";
        $drawings = DB::select($strsql);

        return view('drawing.home',['drawings'=>$drawings]);
    }

    public function view_cad($id)
    {
        
        //id = W-DC2-BULD-B010-AR-2001-001-A
        //dd($id);
        if (($id == null) || ($id == '')) {
            return redirect()->back();
        } else {
            $fn = $id . '.pdf';
            //dd($fn);
            //explode : W-DC2-BULD-B010-AR-2001-001-A
            $pieces = explode("-", $id);
            //dd($pieces[3]);
            $accesskey = env("AZURE_ACCESS_KEY");
            // dd($accesskey);
            // $fullpath = 'docs/Drawings/AR/PDF/W-DC2-BULD-B010-AR-2001-001-A.pdf';
            // $fullpath = Storage::disk('azure')->url('').'Drawings/'.$pieces[4].'/PDF/'.$fn.$accesskey;
            // dd($fullpath);
            // return view('cdcs.viewpdf',[
            //     'id' => $id,
            //     'fullpath' => $fullpath 
            // ]);

            $checkopenpdf = $this->CheckOpenPdf($id);
            //dd($checkopenpdf);
            if ($checkopenpdf == 2 ) {
                //$fullpath = Storage::disk('azure')->url('').'Drawings/'.$pieces[4].'/PDF/FromConsult/'.$fn.$accesskey;
                $fullpath = "https://dccrstorage.file.core.windows.net/docs/Drawings/AR/PDF/FromConsult/W-DC2-BULD-B010-AR-2001-001-A.pdf".$accesskey;
                //dd($fullpath);
                return view('cdcs.viewpdf',[
                    'id' => $id,
                    'fullpath' => $fullpath 
                ]);
            }elseif ($checkopenpdf == 1 ) {
                $fullpath = Storage::disk('azure')->url('').'Drawings/'.$pieces[4].'/PDF/'.$fn.$accesskey;
                return view('cdcs.viewpdf',[
                    'id' => $id,
                    'fullpath' => $fullpath 
                ]);
            }else{
                return redirect()->back() ->with('alert', 'Pdf is nothing');
            }            
        }
    }

    public function CheckOpenPdf($id) {
        //id = W-DC2-BULD-B010-AR-2001-001-A
        $pieces = explode("-", $id);
        //dd(substr($id,2,25));
        //result = 2 is CscEndorsed, 1 is DesignerEndorsed, 0 is Designer Review
        $csc = (new MainController)->MyFind("Drawing_Register",
        "ChkCSC_Endorsed", 
        "WHERE Status = '" . $pieces[0] . "' AND Dwg_no = '" . substr($id,2,25) . "' AND Revision = '" . $pieces[7] . "' ",
        "ORDER BY Dwg_no");
        $dsg = (new MainController)->MyFind("Drawing_Register",
        "ChkAecom_Endorsed", 
        "WHERE Status = '" . $pieces[0] . "' AND Dwg_no = '" . substr($id,2,25) . "' AND Revision = '" . $pieces[7] . "' ",
        "ORDER BY Dwg_no");
        
        if ($csc == 1) {
            $result = 2;
        }elseif ($csc == 0 && $dsg == 1) {
            $result = 1;
        }else{
            $result = 0;
        }
        return $result;
    }


}
