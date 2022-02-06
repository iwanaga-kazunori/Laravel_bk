<style>
  img {
    width: 100% !important;
    height: auto !important;
  }
</style>
<div class="container-lg" style="width:900px;overflow:hidden;margin:0 auto;display:flex;flex-wrap:wrap;">
@foreach($rss_content as $value)
  <div style="width:45%;margin:2%">
    <h2 style="font-size:1em;"><a href="{{$value['permalink']}}">{{$value['title']}}</a></h2>
    <div style="width:45%;float:left;pading:5%;">
      <p>{!!$value['img']!!}</p>
    </div>
    <div style="width:50%;float:right;">
      <p style="font-size:0.9em;">{{$value['description']}}</p>
      <p style="font-size:0.9em;">{{$value['label']}}</p>
      <p style="font-size:0.8em;">{{$value['date']}}</p>
    </div>
  <br><br><br>
  </div>
  
@endforeach
</div>


