<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [

        "tweet_description",
        "tweet_img",
        "tweet_date",
        "tweet_likes"
    ];
}
