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
        $posts = new Delfi();//calling for class Delfi
        $arr = $posts->Rss(); //getting all rss feed
        $array = array_slice($arr['channel']['item'], 0, 14);
        if (is_array($array)) {  //check if tlements are in array due to some delfi news are outside of array
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
        $userSettings = json_decode($user->settings); //getting user prefered channels
        if (!empty($user->settings)) {      // Registered users already have some settings
            foreach ($userSettings->settings as $setting) {
                $myPosts = $posts->myRss($setting);
                array_push($postArray, $myPosts);
            }
        } else {
            foreach ($channels as $userChannel) {
                $myPosts = $posts->myRss($userChannel->id);  //getting rss feed from prefered channels,New user has no settings, therefore all rss feed is presented
                array_push($postArray, $myPosts);
            }
        }
        return view('profile', compact('user', 'channels', 'postArray', 'userSettings'));
    }

    public function userSettings(Request $request)
    {
        $profile = User::where(['id' => Auth::user()->id])->first('id');
        $profile->settings = json_encode(array('settings' => $request->all()));
        $profile->update();
        return Response()->json(['success', 'message' => 'OK'], 200);
    }

}
