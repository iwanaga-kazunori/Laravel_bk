<?php

namespace App\Http\Controllers;

use App\FeedComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\Feed;
use App\Http\Resources\FeedCollection;

class FeedController extends Controller
{
    //
    public function feed()
    {
        $url = 'https://kicker.town/feed';

        // 簡単にXMLを取得する
        $rss = simplexml_load_file($url);

//        $str = preg_replace('/[\x00-\x1f]/',' ',file_get_contents($url));
//        $str = str_replace('<content:' ,'<content_',$str);
//        $str = str_replace('</content:' ,'</content_',$str);
//        $rss = simplexml_load_string($str, NULL, LIBXML_NOCDATA);
        // dd($rss);
        $rss_contents = [];
        foreach($rss->channel->item as $item){

            $title = (string)$item->title;
            $link = (string)$item->link;
            $pubDate = (string)$item->pubDate;
            $date = date('Y/m/d', strtotime($pubDate));
            $category = (string)$item->category[0];
            $guid = (string)$item->guid;
            $newsId = substr($guid, 23);
            $content = (string)$item->description;

//            $content = $item->content_encoded;
            $search = array('<p>','</p>');
            $replace = array('','');
            $content1 = str_replace($search,$replace,$content);
            $content2 = explode ('<br />',$content1);
            $content3 = str_replace ('　','',$content2);
            $img = $content3[0] ?? '';
            $sentence1 = $content3[1] ?? '';
            $sentence1 = mb_substr($sentence1, 0, 40);

            $cont1 = str_replace(['<p>', '</p>'], ['', ''], (string)$item->description);

            //$sentence2 = $content2[2];
            $description = $content2[0];

            // 登録用の配列を作る
            $rss_content = [
                    'title' => $title,
                    'link' => $link,
                    'date' => $date,
                    'category' => $category,
                    'newsId' => $newsId,
                    'description' => $description,
                'content' => '',

                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ];

            $check = Feed::where('link', '=',  $link)->first();
            if ($check === null) {
                // DBに情報がなければ登録する
                Feed::insert($rss_content);
            }
            Feed::insert($rss_content);

            // DBに入れないものを表示用に追加する
            $rss_content['img'] = $img;
            $rss_content['sentence'] = $sentence1;

            // 表示用にすべてを配列に入れる
            $rss_contents[] = $rss_content;
        }

        return view('feed.index', ['rss_content' => $rss_contents]);
    }


    public function feedRead()
    {
        return view('feed.read');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiFeed(): \Illuminate\Http\JsonResponse
    {
        $feed = Feed::orderByDesc('created_at')
            ->limit(5)
            ->get();
        $collection = new FeedCollection($feed);

        return response()->json($collection);
    }

    public function apiStore(Request $request)
    {
        $form = $request->all();

        // 開発用にユーザーIDをセットする
        $form['user_id'] = 1;
        $form['created_at'] = Carbon::now();
        $form['updated_at'] = Carbon::now();

        $feedComment = new FeedComment;

        // これだと created_atとupdated_atが入らない。
        $id = $feedComment->insertGetId($form);

        $result = [
            'data' => $feedComment->get(),
        ];
        return response()->json($result);
    }
}
