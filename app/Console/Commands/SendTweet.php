<?php

namespace App\Console\Commands;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Coderjerk\BirdElephant\BirdElephant;

class SendTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tweets = DB::table('tweets') 
        -> select('*')
        -> where('tweet_update', '=', 0)
        -> get();

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
            $data['tweet_update'] = 1;

            $tweetPost = Tweet::findOrFail($tweet -> id);
            $tweetPost -> update($data);
        
            $tweet = (new \Coderjerk\BirdElephant\Compose\Tweet)->text($tweet -> tweet_description);
        
            $twitter->tweets()->tweet($tweet);
        }
    }

    }
}
