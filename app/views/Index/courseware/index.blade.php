@extends('Index.master')
@section('title')课件 @stop

@section('content')
<div class="container-fluid">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

  <div class="col-md-9">
      <div class="tabtool">
          <div class="clear"></div>
      </div>

      <div class="classes-list">
        @if (isset($lists['files']))
        <table class="table-2" style="width:80%;margin:20px;padding:20px" border="0" cellpadding="0" cellspacing="0">
          @foreach($lists['files'] as $k => $d)
          <tr>
              <td class="tytd">
                <a href="{{$config_path}}{{$d['path']}}index.php" target="_blank" class="play_ware">{{$d['name']}}</a>
              </td>
          </tr>
          <tr><td colspan="2">
              <div class="table-2-sp"></div>
          </td></tr>
          @endforeach
          </table>
        @else
          @foreach($lists as $k => $d)
            @if ($d['pic'] != '')
            <div class="classse-box" style="text-align:center">
              <div>
                <img src="{{$config_path}}{{$d['pic']}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
              </div>
              <div class="classes-txt">
                <a href="/courseware?d1={{$k}}&column_id={{$query['column_id']}}" style="color:#fff;">
                <div><h2><b>{{$d['name']}}</b></h2></div>
                </a>
              </div>
            </div>
            @else
              <div style="width: 100px; float: left; height: 100px; margin: 10px; padding: 10px; text-align: center;">
                <h2><a href="/courseware?d1={{$k}}&column_id={{$query['column_id']}}">{{$d['name']}}</a></h2>
              </div>
            @endif
          @endforeach
        @endif
          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')

<script type="text/javascript">

var winID = null;
  function openFullWindow(url,winname)
  {
     var strFeatures = "left=0,screenX=0,top=0,screenY=0";
     if (window.screen)
     {
         //获取屏幕的分辨率
          var maxh = screen.height;
          var maxw = screen.width;
          strFeatures += ",height="+maxh;
          // strFeatures += "innerHeight"+maxh;
           strFeatures += ",width="+maxw;
          // strFeatures += "innerwidth"+maxw;
     }
     else
     {
         strFeatures +=",resizable";

     }
     winID = window.open(url,winname,strFeatures);

  }


$(document).ready(function () {
  $(".play_ware").on('click', function() {
    // alert($(this).prop('href'));
    openFullWindow($(this).prop('href'), 'newwin');
    // window.open($(this).prop('href'),'',"fullscreen=1,menubar=no,width=800,height=600");
    return false;
  });

});
</script>
@stop


