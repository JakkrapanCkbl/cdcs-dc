<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function MyFind($TableName, $FieldOut, $StrFilter, $OrderBy) {
        $strsql = "SELECT " . $FieldOut . " FROM " . $TableName;
        if($StrFilter != ''){
            $strsql = $strsql . " " . $StrFilter;
        }
        if($OrderBy != ''){
            $strsql = $strsql . " " . $OrderBy;
        }
        $result = DB::select($strsql);
        
        if ($result == null) {
            // dd("null");
            return null;
        }else {
            return $result[0]->$FieldOut;
        }
    }
    
}
