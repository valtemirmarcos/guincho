<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BnpController extends Controller{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        
    }
    public function inicio(Request $request)
    {
        
        $slug = $request->segment(1);
        $arUrl = explode("/".$slug,$request->url());

        return view('main',['slug' => $slug, 'url'=>$arUrl[0] ]);
    }
    public function dadosUsuario($slug)
    {
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('URL_API').'/admin/buscarDadosUsuario?slug=' . $slug,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
        curl_close($curl);
    
        if ($err) {
            return response()->json(['error' => $err], 500);
        }
    
        if ($http_code !== 200) {
            return response()->json(['error' => 'HTTP Code ' . $http_code], $http_code);
        }
    
        $data = json_decode($response, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'JSON Decode Error: ' . json_last_error_msg()], 500);
        }
        
    
        return $data;
    }
    
}