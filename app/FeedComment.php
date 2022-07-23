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
    public static $rules = array(
        'news_id' => 'required',
        'edited_at' => 'required',
    );

    public function feed() {
        return $this->belongsTo('App\Feed', 'news_id', 'news_id');
    }
}
