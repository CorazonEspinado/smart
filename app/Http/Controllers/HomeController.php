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
        $arr = $posts->Rss();
        $con = json_encode($arr);
        $newArr = json_decode($con, true);
        $array = $newArr['channel']['item'];
        if (is_array($array)) {
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
        if (!empty(Auth::user()->settings)) {
            $userSettings = json_decode(Auth::user()->settings);
            foreach ($userSettings->settings as $setting) {
                $myPosts = $posts->myRss($setting);
                array_push($postArray, $myPosts);
            }
        } else {
            $userChannels = Channel::all();
            foreach ($userChannels as $userChannel) {
                $myPosts = $posts->myRss($userChannel->id);
                array_push($postArray, $myPosts);
            }
        }
        return view('profile', compact('user', 'channels', 'postArray','userSettings'));
    }

    public function userSettings(Request $request)
    {

        $profile = User::where(['id' => Auth::user()->id])->first('id');
        $profile->settings = json_encode(array('settings' => $request->all()));
        $profile->update();
//        return  ($request->all());
        return Response()->json(['success', 'message' => 'OK'], 200);

    }


}
