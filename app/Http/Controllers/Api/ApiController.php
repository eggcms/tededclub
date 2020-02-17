<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function hdp() {
        $json = file_get_contents('https://zeanza.com/mm88fa-api/vision_data/api.php?met=hdp&APIkey=S09ZWFArak1BZTNpcUZGNTA2YWVia2tjU0F0bUVyazNZdjJVSGpZWXJMcDlrWHFYRGNnYlRjTWphaFg1RUVVWGh6WjNsUDZ6WUJKeDlCYUFRZzdrenc9PTo6G5mkISD1Nfndtt7QHBsBSA==');
        $objs = json_decode($json);
        //return view('home.fpage')->with('objs', $objs));   
     }
    public function stepdata(Request $request) {
        // $json=file_get_contents('https://zeanza.com/mm88fa-api/vision_data/api.php?met=stp&APIkey=S09ZWFArak1BZTNpcUZGNTA2YWVia2tjU0F0bUVyazNZdjJVSGpZWXJMcDlrWHFYRGNnYlRjTWphaFg1RUVVWGh6WjNsUDZ6WUJKeDlCYUFRZzdrenc9PTo6G5mkISD1Nfndtt7QHBsBSA==');
        // $obj = json_decode($json);

        // $ints=Blog::where('cid',1)->where('status',1)->orderBy('visit','desc')->take(5)->get();
        // $ups=Blog::where('cid',1)->where('status',1)->orderBy('id','desc')->take(5)->get();
        // return view('home.fpage')->with('obj', $obj)->with('cmd', 'step-api')->with('ints',$ints)->with('ups',$ups);  
    }
}
