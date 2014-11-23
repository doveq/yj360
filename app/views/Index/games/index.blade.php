@extends('Index.master')
@section('title')课件 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
          {{$column_name}}
          {{Form::open(array('url' => '/games?column_id='.$query['column_id'].'&id='.$query['id'], 'method' => 'get', 'style' => 'margin-left:20px;float:right;'))}}
           {{Form::text('q', '', array('style' => 'padding:2px;') )}}
           {{Form::hidden('column_id', $query['column_id'])}}
           {{Form::hidden('id', $query['id'])}}
           {{Form::submit('检索', array('style' => 'background-color:#00b1bc;border:none;color:#fff;padding:2px 5px;') )}}
          {{ Form::close() }}
      </div>

      <div class="classes-list">
        @if (!empty($lists))
          @foreach($lists as $k => $d)
            <div style="float:left;
            margin-bottom: 20px;
            margin-left:10px;
            padding: 4px;
            text-align:center;
            overflow: hidden;width:140px;height:168px;">
                @if ($d['pic'] != '')
                <a href="/games/show?column_id={{$query['column_id']}}&id={{$query['id']}}&path={{$d['path']}}&filename={{$d['pinyin']}}" target="_blank" class="play_ware"><img src="{{$config_path.$d['pic']}}" style="margin:0 auto;"></a>
                @endif
                <div style="padding:9px;text-align:center;" class="label">
                    <a style="color:#000;" href="/games/show?column_id={{$query['column_id']}}&id={{$query['id']}}&path={{$d['path']}}&filename={{$d['pinyin']}}" target="_blank" class="play_ware">{{$d['name']}}</a>
                </div>
              </div>
            @endforeach
          <div class="clear"></div>
        @endif
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
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


