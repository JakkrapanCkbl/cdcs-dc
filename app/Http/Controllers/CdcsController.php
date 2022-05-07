<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Auth;


class CdcsController extends Controller
{
    

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
            if (Auth::user()->ViewConfidential) {
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
            
            return view('viewpdf',[
                'id' => $id,
                'fullpath' => $fullpath 
            ]);
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
