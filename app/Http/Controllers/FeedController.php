<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use FeedReader;

class FeedController extends Controller
{
    //
    public function feed()
    {
        
        $feed = FeedReader::read('https://kicker.town/feed');

        if ( $feed->error() ) {
            echo $feed->error();
        }

        foreach ($feed->get_items() as $item) {
                //$hash = [];
                //$hash['site_title'] = $item->get_feed()->get_title();
                //$site_title = $item->get_feed()->get_title();
                //$hash['title'] = trim($item->get_title());
            $title = $item->get_title();
            $description = $item->get_description();
            $category = $item->get_category();
            $label = $category->get_label();
            
                //$hash['permalink'] = trim($item->get_permalink());
            $permalink = $item->get_permalink();
            $date = $item->get_date('Y/m/d');
                //$hash['link'] = trim($item->get_link());
                //$hash['date'] = $item->get_date('Y-m-d H:i:s');
                //$hash['content'] = $item->get_content();
            $content = $item->get_content();
            $search = array('<p>','</p>','<br>');
            $replace = array('','','');
            $content1 = str_replace($search,$replace,$content);
            $content2 = explode ('　',$content1);
            $img = $content2[0];
            //$sentence1 = $content2[1];
            //$sentence2 = $content2[2];
            
            //for ($i = 1; $i < 10 ;$i++){
                //if( empty($content2[$i]) ){
                    //continue;
                //} else {
                    //$content.$i = $content[$i];
                //}
            //}
            //echo $title;
            //echo "<br>\n";
            //echo $label;
            //echo "<br>\n";
            //echo $description;
            //echo "<br>\n";
            //echo $content;
            //echo "<br>\n";
            //echo $img;
            //echo "<br>\n";
            //echo $sentence1;
            //echo "<br>\n";
            //echo $sentence2;
            //echo "<br>\n";
            //echo "////////////////////";
            //echo "<br>\n";
            //echo $content2[3];
            //echo "<br>\n";
            //echo $content2[4];
            //echo "<br>\n";
            //echo $content2[5];
            //echo "<br>\n";
            //echo $content2[6];
            //echo "<br>\n";
            //echo $content2[7];
            //echo "<br>\n";
                //$hash['category'] = $item->get_category();
                //$hash['description'] = $item->get_description();
            //$site_body = $item->get_feed();
            $rss_content[] = [
                    //'site_title' => $site_title,
                'title' => $title,
                'label' => $label,
                'permalink' => $permalink,
                'description' => $description,
                //'content' => $content,
                'img' => $img,
                'date' => $date,
                //'sentence1' => $sentence1,
                //'sentence2' => $sentence2,
                //'site_body' => $site_body
                
                ];
        }
        //echo print_r($hash);
        
        return view('feed.index', ['rss_content' => $rss_content]);
    }
}
