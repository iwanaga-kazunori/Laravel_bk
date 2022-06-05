<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedComment extends Model
{
    //

    protected $fillable = [
        'comment',
        'feed_id',
        'user_id',
        'news_id'
    ];
}
