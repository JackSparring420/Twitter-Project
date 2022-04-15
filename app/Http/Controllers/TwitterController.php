<?php

namespace App\Http\Controllers;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;

class TwitterController extends Controller
{
    public function home(){
        return view('pages.home');
    }

    public function profile(){
        $tweets = Tweet::all()->sortByDesc('tweet_date');
        $current = Carbon::now('Europe/Stockholm');
        
        return view('pages.my-tweets', compact('tweets', 'current'));
    }

    public function MyTweets(){
        // $tweets = Tweet::all()->sortByDesc('tweet_date');
        $tweets = DB::table('tweets') 
        -> select('*')
        -> orderBy('tweet_date', 'desc')
        -> get();

        return response()->json($tweets);
    }


    public function create(Request $request) {

        $data = $request -> validate([
            'tweet_description' => 'required|string|max:255',
            'tweet_img' => 'string|max:255',
            'tweet_date' => 'required|date',
        ]);
        // default number of likes
        $data['tweet_likes'] = 0;

        $tweet = Tweet::create($data);

        return redirect() -> route('profile');
    }

    public function delete($id) {

        $tweet = Tweet::findOrFail($id);

        $tweet -> delete();
        return json_encode($tweet);
    }

    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         Tweet::all();
    //     })->daily();
    // }
}
