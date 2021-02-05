<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FilmController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function pagination(Request $request){
        $this->validate($request, [
            'keywords'=>'required',
            'page'=>'required'
        ]);
        $key = $request->keywords;
        $page = $request->page;
        try{
            
            $curlConnection = curl_init();
            curl_setopt($curlConnection, CURLOPT_URL, 'http://www.omdbapi.com/?apikey=faf7e5bb&s='.$key.'&type=movie&page='.$page);
            curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, true);
            $movieList = curl_exec($curlConnection);
            curl_close($curlConnection);
            $movieList = json_decode($movieList);
            usort($movieList->Search, function ($a, $b) {
                return $a->Year > $b->Year ? -1 : 1;
            });
            return response()->json([
                'status'=>200, 
                'movie'=>$movieList->Search
            ]);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>201,
                'message'=>'Fail'
            ]);
        }
    
    }

    public function searching(Request $request){
        $this->validate($request, [
          'keywords'=>'required'  
        ]);
        $key = $request->keywords;
        try {

            $curlConnection = curl_init();
            curl_setopt($curlConnection, CURLOPT_URL, 'http://www.omdbapi.com/?apikey=faf7e5bb&s=' . $key . '&type=movie');
            curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, true);
            $movieList = curl_exec($curlConnection);
            curl_close($curlConnection);
            $movieList = json_decode($movieList);
            usort($movieList->Search, function($a, $b){
                return $a->Year > $b->Year ? -1:1;
            });
            return response()->json([
                'status' => 200,
                'movie' => $movieList->Search
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 201,
                'message' => 'Fail'
            ]);
        }
    }
}
