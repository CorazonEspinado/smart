<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Client;
use App\Http\Classes\Delfi;


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
    public function index()
    {
        $posts = new Delfi();
        $response=$posts->Rss();
//        $xml = simplexml_load_string($response);
//        $json = json_encode($xml);
//        $array = json_decode($json,TRUE);
//        dd($array);
        return view('home', compact('response'));
    }
}
