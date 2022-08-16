<style>
  img {
    width: 100% !important;
    height: auto !important;
  }
</style>
<script src="{{ asset('js/app.js') }}" defer></script>
<div id="app">
  <spinner></spinner>
</div>
<div class="container-lg" style="width:900px;overflow:hidden;margin:0 auto;display:flex;flex-wrap:wrap;">
@foreach($rss_content as $value)
  <div style="width:45%;margin:2%">
    <h2 style="font-size:1em;height:2em">{{ $value['title'] }}</h2>
    <div style="width:45%;float:left;padding:2%;">
      <img src="{{ $value['img_path'] }}">
    </div>
    <div style="width:50%;float:right;">
      <p style="font-size:0.9em;">{{ $value['description'] }}&hellip;</p>
      <p style="font-size:0.9em;">{{ $value['team'] }}</p>
      <p style="font-size:0.8em;">{{ $value['date'] }}</p>
      {{ $value['news_id'] }}
    </div>
  <br><br><br>
  </div>
  
@endforeach
{{ $rss_content->links() }}
</div>


