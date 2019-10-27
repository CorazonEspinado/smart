<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Client;
use App\Http\Classes\Delfi;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Channel;


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
        $arr = $posts->Rss(); //getting all rss feed
        $array =  array_slice($arr['channel']['item'],0, 14);
        if (is_array($array)) {  //check if components are in array due to some delfi news are out of array
            $title = $array['title'];
            $description = $array['description'];
            $link = $array['link'];
        }
        return view('home', compact('array', 'title', 'description', 'link'));
    }

    public function Profile()
    {
        $channels = Channel::all();
        $postArray = [];
        $posts = new Delfi();
        $user = Auth::user();
        $settingsDefined = json_decode(Auth::user()->settings); //getting user prefered channels
        if (!empty(Auth::user()->settings)) {      // Registered users already have some settings
            $userSettings = json_decode(Auth::user()->settings);
            foreach ($userSettings->settings as $setting) {
                $myPosts = $posts->myRss($setting);
               array_push($postArray, $myPosts);
            }
        } else {
            $userChannels = Channel::all();   //New user has no settings, therefore all rss feed is presented
            foreach ($userChannels as $userChannel) {
                $myPosts = $posts->myRss($userChannel->id);  //getting rss feed from prefered channels
                array_push($postArray, $myPosts);
            }
        }
        return view('profile', compact('user', 'channels', 'postArray', 'userSettings', 'settingsDefined'));
    }

    public function userSettings(Request $request)
    {
        $profile = User::where(['id' => Auth::user()->id])->first('id');
        $profile->settings = json_encode(array('settings' => $request->all()));
        $profile->update();
        return Response()->json(['success', 'message' => 'OK'], 200);
    }

}
