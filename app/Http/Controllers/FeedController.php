<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\Feed;

class FeedController extends Controller
{
    //
    public function feed()
    {
        $url = 'https://kicker.town/feed';
        $str = preg_replace('/[\x00-\x1f]/',' ',file_get_contents($url));
        $str = str_replace('<content:' ,'<content_',$str);
        $str = str_replace('</content:' ,'</content_',$str);
        $rss = simplexml_load_string($str, NULL, LIBXML_NOCDATA);
        // dd($rss);
        $rss_content = [];
        foreach($rss->channel->item as $item){
        
        $title = $item->title;
        $link = $item->link;
        $pubDate = $item->pubDate;
        $date = date('Y/m/d', strtotime($pubDate));
        $category = $item->category[0];
        $guid = $item->guid;
        $newsId = substr($guid, 23);
        $description = $item->description;
        
        $content = $item->content_encoded;
        $search = array('<p>','</p>');
        $replace = array('','');
        $content1 = str_replace($search,$replace,$content);
        $content2 = explode ('<br />',$content1);
        $content3 = str_replace ('　','',$content2);
        $img = $content3[0];
        $sentence1 = $content3[1];
        $sentence1 = mb_substr($sentence1, 0, 40);
        //$sentence2 = $content2[2];
        
        $rss_content[] = [
                'title' => $title,
                'link' => $link,
                'date' => $date,
                'category' => $category,
                'newsId' => $newsId,
                'description' => $description,
                'content' => $content,
                
                'img' => $img,
                'sentence' => $sentence1,
        ];
        }
        $feed = new Feed;
        $feed->fill($rss_content);
        $feed->save();
        return view('feed.index', ['rss_content' => $rss_content]);
    }
}
