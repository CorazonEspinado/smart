<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Client;
use App\Http\Classes\Delfi;
use App\Helpers\Xml;
use Illuminate\Support\Facades\Auth;


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
        //calling for class Delfi
        $posts = new Delfi();
        $arr = $posts->Rss();
        $con = json_encode($arr);
        $newArr = json_decode($con, true);
        $array=$newArr['channel']['item'];
        if (is_array($array)) {
            $title=$array['title'];
            $description=$array['description'];
            $link=$array['link'];
        }
           return view('home', compact('array','title','description','link'));
    }

    public function Profile() {
     $user=Auth::user();
       return view ('profile', compact('user'));
    }
}
