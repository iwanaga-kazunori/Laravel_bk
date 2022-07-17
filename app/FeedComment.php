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

    public function feed() {
        return $this->belongsTo(Feed::class, 'news_id');
    }
}
