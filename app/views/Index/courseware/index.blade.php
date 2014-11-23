@extends('Index.master')
@section('title')课件 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        @if ($back_url && isset($query['d1']))
        <a href="{{$back_url}}" style="color:#499626;background-color:transparent;">&lt; 返回</a>
        @endif
          {{$column_name}}
          {{Form::open(array('url' => '/courseware?column_id='.$query['column_id'].'&id='.$query['id'].'&type=' . $query['type'], 'method' => 'get', 'style' => 'margin-left:20px;float:right;'))}}
           {{Form::text('q', '', array('style' => 'padding:2px;') )}}
           {{Form::hidden('column_id', $query['column_id'])}}
           {{Form::hidden('id', $query['id'])}}
           {{Form::hidden('type', $query['type'])}}
           {{Form::submit('检索', array('style' => 'background-color:#00b1bc;border:none;color:#fff;padding:2px 5px;') )}}
          {{ Form::close() }}
      </div>

      <div class="classes-list">
        @if (isset($lists['files']))
          @foreach($lists['files'] as $k => $d)
            <a style="background-color:{{$color[array_rand($color)]}};" href="/courseware/show?column_id={{$query['column_id']}}&id={{$query['id']}}&type={{$query['type']}}&path={{$d['path']}}&filename={{$d['pinyin']}}" target="_blank" class="play_ware cwblock">{{$d['name']}}</a>
          @endforeach
        <!--
        <table class="table-2" style="width:80%;margin:20px;padding:20px" border="0" cellpadding="0" cellspacing="0">
          @foreach($lists['files'] as $k => $d)
          <tr>
              <td class="tytd">
                <a href="/courseware/show?column_id={{$query['column_id']}}&id={{$query['id']}}&type={{$query['type']}}&path={{$d['path']}}&filename={{$d['pinyin']}}" target="_blank" class="play_ware">{{$d['name']}}</a>
              </td>
          </tr>
          <tr><td colspan="2">
              <div class="table-2-sp"></div>
          </td></tr>
          @endforeach
          </table>
        -->
        @else
          @foreach($lists as $k => $d)
            <div style="float:left;
            margin-bottom: 20px;
            width:25%;
            margin-left:10px;
            padding: 4px;
            text-align:center;">
                @if ($d['pic'] != '')
                <a href="/courseware?d1={{$k}}&column_id={{$query['column_id']}}&id={{$query['id']}}&type={{$query['type']}}"><img src="{{$config_path.$d['pic']}}" style="margin:0 auto;"></a>
                @endif
                <div style="padding:9px;text-align:center;" class="label">
                  <h4><a href="/courseware?d1={{$k}}&column_id={{$query['column_id']}}&id={{$query['id']}}&type={{$query['type']}}">{{$d['name']}}</a></h4>
                </div>
              </div>
            @endforeach
        @endif
          <div class="clear"></div>
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


