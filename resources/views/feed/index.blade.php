<style>
  img {
    width: 100% !important;
    height: auto !important;
  }
</style>
<div class="container-lg" style="width:900px;overflow:hidden;margin:0 auto;display:flex;flex-wrap:wrap;">
@foreach($rss_content as $value)
  <div style="width:45%;margin:2%">
    <h2 style="font-size:1em;height:2em"><a href="{{$value['link']}}">{{$value['title']}}</a></h2>{{$value['newsId']}}
    <div style="width:45%;float:left;pading:5%;">
      <p>{!!$value['img']!!}</p>
    </div>
    <div style="width:50%;float:right;">
      <p style="font-size:0.9em;">p1:{!!$value['sentence']!!}&hellip;</p>
      <p style="font-size:0.9em;">p2:{{$value['category']}}</p>
      <p style="font-size:0.8em;">p3:{{$value['date']}}</p>
    </div>
  <br><br><br>
  </div>
  
@endforeach
</div>


