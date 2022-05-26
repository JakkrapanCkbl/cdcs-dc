<?php

namespace App\Http\Controllers\Cdcs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CdcsController extends Controller
{
    
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

        return view('cdcs.home',['incomings'=>$incomings, 'outgoings'=>$outgoings]);
    }
    
    function check(Request $request){
        // $request->validate([
        //     'loginname'=>'required|loginname|exists:users,loginname',
        //     'password'=>'required'
        // ]);

        $creds = $request->only('loginname','password');

        if(Auth::guard('cdcs')->attempt($creds)) {
            return redirect()->route('cdcs.home');
        }else{
            return redirect()->route('cdcs.login')->with('fail','Incorrect Credentials');
        }
    }

    function logout(){
        // dd('ok');
        Auth::guard('cdcs')->logout();
        return redirect('/');
    }

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
                ->paginate(20);
                $incomings->appends($request->all());
            
            $outgoings  = DB::table('vwShowGridOut')
                ->where('ClassID','=','O')
                ->where('RegisterID','not like','%OB%')
                ->where('ShowContract', 'like','%'.$ct.'%')
                ->where(function($query) use ($sf, $search_text){
                    $query->where($sf,'like','%'.$search_text.'%');
                })
                ->orderBy('IssuedDate', 'DESC')
                ->paginate(20);
                $outgoings->appends($request->all());
            
            return view('cdcs.home',['incomings'=>$incomings, 'outgoings'=>$outgoings, 'ct'=>$ct, 'sf'=>$sf, 'inputs'=>$input]);
        }
    }

    public function view_pdf($id)
    {
        // dd($id);
        if (($id == null) || ($id == '')) {
            return redirect()->back();
        }

        $docconf = $this->CheckDocConfidentail($id);
        // dd($docconf);

        if ($docconf == '1') {
            // dd('aut conf = '.Auth::user()->ViewConfidential);
            // Auth::guard('it')->user()->LoginName
            if (Auth::guard('cdcs')-user()->ViewConfidential) {
                $isopen = '1';
            }else{
                $isopen = '0';
            }
        }else{
            $isopen = '1';
        }
        // dd('is open = '.$isopen);

        if ($isopen == '1') {
            // substr("LS1-00-IB-BUDG-00001", 0, 2);
            $mm = substr($id, 5, 2);
            // dd($mm);
            // get MM-YYYY
            $mm_yyyy = $this->GetMY_Folder($mm);
            // dd($mm_yyyy);
            // get fn
            $fn = $this->GetFn($id);
            // dd($fn);
            //  $fullpath = 'storage/cdcs-ppls/docs/00-2022/PLS1-00-IB-BUDG-00001/PLS1-00-IB-BUDG-00001-742266341.pdf';
            // storage/cdcs-ppls/docs/00-2022/PLS1-00-IB-BUDG-00001/PLS1-00-IB-BUDG-00001-742266341.pdf
            // storage/cdcs-ppls/docs/01-2022/PLS1-01-IM-CONT-00018/PLS1-01-IM-CONT-00018-30APR22-01.pdf
            // $fullpath = 'storage/cdcs-ppls/docs/'.$mm_yyyy.'/'.$id.'/'.$fn;
            // $accesskey = "?sv=2020-08-04&ss=f&srt=sco&sp=rwdlc&se=2027-12-31T11:19:49Z&st=2022-03-16T03:19:49Z&spr=https&sig=BH4be9fKMnR%2BmnTd%2FPwdnJbOMleYYpAS%2BywaTpank60%3D";
            $accesskey = env("AZURE_ACCESS_KEY");
            // dd($accesskey);
            $fullpath = Storage::disk('azure')->url('').'Letters/'.$mm_yyyy.'/'.$id.'/'.$fn.$accesskey;
            // dd($fullpath);
            
            return view('cdcs.viewpdf',[
                'id' => $id,
                'fullpath' => $fullpath 
            ]);
        }else{
            return redirect()->back() ->with('alert', 'Confidentail Document! ');
        }
        
       
    }

    public function download_pdf($id)
    {
        // dd($id);
        //PDF file is stored under project/public/download/info.pdf
        // $file= public_path(). "/download/info.pdf";
        // dd($id);
        if (($id == null) || ($id == '')) {
            return redirect()->back();
        }

        $docconf = $this->CheckDocConfidentail($id);
        // dd($docconf);

        if ($docconf == '1') {
            // dd('aut conf = '.Auth::user()->ViewConfidential);
            // Auth::guard('it')->user()->LoginName
            if (Auth::guard('cdcs')-user()->ViewConfidential) {
                $isopen = '1';
            }else{
                $isopen = '0';
            }
        }else{
            $isopen = '1';
        }
        // dd('is open = '.$isopen);

        if ($isopen == '1') {
            // substr("LS1-00-IB-BUDG-00001", 0, 2);
            $mm = substr($id, 5, 2);
            // dd($mm);
            // get MM-YYYY
            $mm_yyyy = $this->GetMY_Folder($mm);
            // dd($mm_yyyy);
            // get fn
            $fn = $this->GetFn($id);
            // dd($fn);
            //  $fullpath = 'storage/cdcs-ppls/docs/00-2022/PLS1-00-IB-BUDG-00001/PLS1-00-IB-BUDG-00001-742266341.pdf';
            // storage/cdcs-ppls/docs/00-2022/PLS1-00-IB-BUDG-00001/PLS1-00-IB-BUDG-00001-742266341.pdf
            // storage/cdcs-ppls/docs/01-2022/PLS1-01-IM-CONT-00018/PLS1-01-IM-CONT-00018-30APR22-01.pdf
            // $fullpath = 'storage/cdcs-ppls/docs/'.$mm_yyyy.'/'.$id.'/'.$fn;
            // $accesskey = "?sv=2020-08-04&ss=f&srt=sco&sp=rwdlc&se=2027-12-31T11:19:49Z&st=2022-03-16T03:19:49Z&spr=https&sig=BH4be9fKMnR%2BmnTd%2FPwdnJbOMleYYpAS%2BywaTpank60%3D";
            $accesskey = env("AZURE_ACCESS_KEY");
            // dd($accesskey);
            $fullpath = Storage::disk('azure')->url('').'Letters/'.$mm_yyyy.'/'.$id.'/'.$fn.$accesskey;
            //  dd($fullpath);
            $headers = array(
                'Content-Type: application/pdf',
                );

            return Response::download($fullpath, 'filename.pdf', $headers);
        }else{
            return redirect()->back() ->with('alert', 'Confidentail Document! ');
        }
        
    }


    public function GetMY_Folder($mm) {
        $result = DB::table('ProjectCalendar')
        ->where('ProjectMonth','=',$mm)
        ->first();
        if ($result == null) {
            return '00-2022';
        }else{
            return $mm.'-'.$result->RealYear;
        }
      
    }

    public function GetFn($id) {
        $result = DB::table('Register_Files')
        ->where('RegisterID','=',$id)
        ->where('FileName','like','%.pdf')
        ->first();
        if ($result == null) {
            return redirect()->back() ->with('alert', $id.' is nothing.');
        }else{
            return $result->FileName;
        }
       
    }

    public function CheckDocConfidentail($id) {
            $result = DB::table('RegisterDoc')
            ->where('RegisterID','=',$id)
            ->first();
            if ($result == null) {
                return redirect()->back() ->with('alert', $id.' is nothing.');
            }else{
                return $result->Confidential;
            }
    }

    public function show($id) {
        // return $id;
        $data = [
            '1' => 'PLS1-00-IB-BUDG-00001-742266341.pdf',
            '2' => 'PLS1-00-IB-BUDG-00002-742267544.pdf',
            '3' => 'PLS1-00-IM-CM1A-00005-184221122179.pdf'
        ];
        // dd($data[$id]);
        
        if (Storage::disk('share-drive')->exists('file.txt')) {
            dd('OK');
        }else{
            return view('viewpdf',[
                'filename' => $data[$id] ?? 'file name ' . $id 
            ]);
        }
    }

    public function getdrive(){
        // dd(Storage::disk('azure'));
        // https://dccrstorage.file.core.windows.net/docs/Letters/00-2022/DC02-00-IE-PM02-00001/DC02-00-IE-PM02-000011632228137.pdf
        if (Storage::disk('azure')->exists('test1.pdf')) {
            // dd('okx');
            $contents = Storage::disk('azure')->url('test1.pdf');
            dd($contents);
        }
        else{
            dd('nothing x');
        }
        return true;
    }

}
