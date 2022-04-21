<?php

namespace App\Http\Controllers;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\DB;
use Abraham\TwitterOAuth\TwitterOAuth;
use Coderjerk\BirdElephant\BirdElephant;
use Atymic\Twitter\Twitter as TwitterContract;

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

    public function createVue(Request $request) {

        $data = $request -> validate([
            'tweet_description' => 'required|string|max:255',
            'tweet_date' => 'required|date',
        ]);
        // default number of likes
        $data['tweet_likes'] = 0;
        $data['tweet_update'] = 0;
        // validate img if present
        if ($request -> file('tweet_img') != '') {
            $imageFile = $request -> file('tweet_img');
            $data['tweet_img'] = $request -> validate([
                'tweet_img' => 'image',      
            ]);
            $data['tweet_img'] = $imageFile;
            // rename and store dish img
            $imageName = rand(100000, 999999) . '_' . time() . '.' . $imageFile -> getClientOriginalExtension();
            $imageFile -> storeAs('/tweet/', $imageName, 'public');
            $data['tweet_img'] = $imageName;
        }

        $tweet = Tweet::create($data);

        return response()->json($tweet);
    }


    public function delete($id) {

        $tweet = Tweet::findOrFail($id);

        $tweet -> delete();
        return json_encode($tweet);
    }

    public function postTweet() {
        // get tweets
        $tweets = DB::table('tweets') 
        -> select('*')
        -> where('tweet_update', '=', 0)
        -> get();
        //credentials of twitter
        $credentials = array(
            'bearer_token' => env('TWITTER_BEARER_TOKEN'), // OAuth 2.0 Bearer Token requests
            'consumer_key' => env('TWITTER_CONSUMER_KEY'), // identifies your app, always needed
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET'), // app secret, always needed
            'token_identifier' => env('TWITTER_ACCESS_TOKEN'), // OAuth 1.0a User Context requests
            'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'), // OAuth 1.0a User Context requests
        );

        foreach($tweets as $tweet){
            if($tweet ->tweet_date <= Carbon::now('Europe/Stockholm')){
            
                $twitter = new BirdElephant($credentials);
                $data['tweet_update'] = 0;


                //only works with API v1
                if( $tweet -> tweet_img !== NULL ){
                    // first, use the tweeets()->upload method to upload your image file
                    $image = $twitter->tweets()->upload("./storage/tweet/{$tweet -> tweet_img}");
                    // //pass the returned media id to a media object as an array
                    $media = (new \Coderjerk\BirdElephant\Compose\Media)->mediaIds(
                        [
                            $image->media_id_string
                        ]
                    );
    
                    $tweetPost = Tweet::findOrFail($tweet -> id);
                    $tweetPost -> update($data);
                    $tweet = (new \Coderjerk\BirdElephant\Compose\Tweet)->text($tweet -> tweet_description)->media($media);
                }else{
                    $tweetPost = Tweet::findOrFail($tweet -> id);
                    $tweetPost -> update($data);
                    $tweet = (new \Coderjerk\BirdElephant\Compose\Tweet)->text($tweet -> tweet_description);
                }  

            
                $twitter->tweets()->tweet($tweet);
            }
        }
    }

}
