@extends('Index.master')
@section('title')我的消息 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
          <a href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @foreach($lists as $k => $v)
        <div style="border-bottom: 1px dashed #cdcdcd">
          <div style="float: left; margin: 0px 0px 8px;">
            <img src="{{Attachments::getAvatar($v->sender_id)}}" width="48" height="48" style="border:1px solid #f2f2f2;padding:2px;"/>
          </div>
          <div style="padding: 0px 0px 0px 60px; margin: 8px 0px;" class="msg-box" data-id="{{$v->id}}">
            <div style="color: rgb(73, 149, 40); font-weight: 700;">
              @if ($v->sender_id == Session::get('uid'))
              您对 {{$v->receiver->name}} 说:
              @else
              {{$v->sender->name}} 对你说:
              @endif
            </div>
            <div>
              @if ($v->status == 0)
                  <b><a href="/message/{{$v->id}}?column_id={{$query['column_id']}}" style="color:#000;">{{$v->content}}</a></b>
              @else
                  <a href="/message/{{$v->id}}?column_id={{$query['column_id']}}" style="color:#000;">{{$v->content}}</a>
              @endif
            </div>
            <div style="color:#999">
                  {{$v->created_at}}
            </div>
          </div>
        </div>
        @endforeach


          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">
$(function(){
  $(".msg-box").hover(function(){
    $(this).css({'background-color':'#f1f1f1','cursor': 'pointer'});
  }, function(){
    $(this).css('background-color','');
  }).on('click', function() {
    var $this = $(this);
    var msg_id = $this.data("id");
    window.location.replace("/message/"+msg_id+"?column_id={{$query['column_id']}}");

  });
  delete_message = function(id){
    layer.confirm('您确定要删除吗？', function(){
      $.ajax({
      url:'/message/'+id+"?column_id={{$query['column_id']}}",
        // async:false,
        type:'delete',
      })
      .fail(function(){
        layer.msg('删除失败,请刷新重试', 2, 1);
      })
      .success(function(){
        $('#message_'+id).remove();
        layer.msg('删除成功', 1, 1);
      });
    });
  };
});
</script>
@stop


