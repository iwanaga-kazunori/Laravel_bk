<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    //
    protected $guarded = array('id');

    protected $table = 'feed';

    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );

    public function comments()
    {
        return $this->hasMany('App\FeedComment');
    }
}
