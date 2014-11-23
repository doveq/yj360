@extends('Index.master')
@section('title')我的消息 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <a href="/classes/{{$query['class_id']}}?column_id={{$query['column_id']}}" class="tabtool-btn-back">返回></a>
        <span class="tab-title">{{$classes->name}}></span>
        <span class="tab-title">与{{$user->name}}对话</span>
        <span class="tab-btn">
          <a href="javascript:void(0);" onClick="delete_message();" class="tabtool-btn">全部清除</a>
        </span>
        <span class="" style="float:right; margin-right:10px;">共有{{$allnums}} 条对话</span>

      </div>
      <div class="clear"></div>

      <div class="classes-list">
        {{ Form::open(array('url' => '/message?column_id='.$query['column_id'].'&class_id='.$query['class_id'].'&user_id='.$query['user_id'], 'method' => 'post')) }}
        <div>
          <div style="float: left; margin: 8px 0px 8px;position: relative;width:72px;">
          </div>
          <div style="margin: 8px 0px; float:left; width:600px;">
            <div>
            {{ Form::textarea('content', '', array('class' => '', 'id' => 'inputContent', 'style' => 'border: 1px solid #ccc; border-radius: 5px;width:600px', 'rows' => 3)) }}
            </div>
          </div>
          <div style="float: left; margin: 8px 0px 8px 20px;position: relative;width:72px;">
            {{ Form::hidden('dialog', 1) }}
            {{ Form::submit('发送', array('class' => '', 'style' => 'height: 48px; width: 48px;')) }}

          </div>
        </div>
        <div class="clear"></div>
        <div style="padding:10px;">{{ HTML::ul($errors->all()) }}</div>

        {{Form::close();}}
          @foreach($messages as $k => $v)

          @if ($v->sender_id == Session::get('uid'))
            <div id="message_{{$v->id}}"  style="margin: 5px 0;">
              <div style="float: left; margin:1px 0;position: relative;width:72px; height:82px;">
              </div>
              <div style="margin: 0px; float:left; width:600px;" class="msg-box" data-id="{{$v->id}}">
                <div style="border: 1px solid #ccc; border-radius: 5px; padding: 10px 5px;background-color:#00CC66;color:#fff;">
                      {{$v->content}}
                      <br/>
                       <div style="color:#ccc;font-size:8pt;" class="msg-date">
                      {{$v->created_at}}
                      </div>
                </div>
              </div>
              <div style="float: left; margin: 0px;position: relative;width:72px;">
                <img src="/assets/img/msg-arrow2.png" style="float: left; top: 15px; position: absolute;transform: rotate(180deg);margin:-3px;">
                <div style="padding:2px;float:right;width:48px;text-align:center;">
                  <img src="{{Attachments::getAvatar($v->sender_id)}}" width="48" height="48" style="padding:2px;border:1px solid #f2f2f2;"/>
                  <div style="color:#999;font-size:9pt;margin-top: -8px;">{{$v->sender->name}}</div>
                </div>
              </div>
            </div>
          @else
            <div id="message_{{$v->id}}" style="margin:0px;">
              <div style="float: left; margin: 1px 0; position: relative;width:72px;">
                <div style="float:left;width:48px;text-align:center;">
                  <img src="{{Attachments::getAvatar($v->sender_id)}}" width="48" height="48" style="padding:2px;border:1px solid #f2f2f2;"/>
                  <div style="color:#999;font-size:9pt;margin-top: -8px;">{{$v->sender->name}}</div>
                </div>
                <img src="/assets/img/msg-arrow1.png" style="float: right; top: 15px;right:-3px; position: absolute;">
              </div>
              <div style="margin:0px; float:left; width:600px;" class="msg-box" data-id="{{$v->id}}">
                <div style="border: 1px solid #ccc; border-radius: 5px; padding: 10px 5px;">
                      {{$v->content}}
                      <br/>
                       <div style="color:#999;font-size:8pt;" class="msg-date">
                      {{$v->created_at}}
                      </div>
                      <div class="clear"></div>
                </div>
              </div>
              <div style="float: left; margin:0px;position: relative;width:72px;height:82px;">
              </div>
            </div>
          @endif
            <div class="clear"></div>
          @endforeach
          <div class="pages" style="text-align:center;">
                       {{$messages->appends($query)->links()}}
           </div>
        </div>

      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>
<script type="text/javascript">
$(function(){
  $(".msg-box").hover(function(){
    $(this).children(".msg-date").children(".msg-delete").css('display','block');
  }, function(){
    $(this).children(".msg-date").children(".msg-delete").css('display','none');
  });

  delete_message = function(id){
    layer.confirm('您确定要删除吗？', function(){
      $.ajax({
      url:'/message/delete_all?user_id='+{{$query['user_id']}}+'&column_id='+{{$query['column_id']}}+'&class_id='+{{$query['class_id']}},
        // async:false,
        type:'get',
      })
      .fail(function(){
        layer.msg('删除失败,请刷新重试', 2, 1);
      })
      .success(function(){
        layer.msg('删除成功', 1, 1);
        location.reload();
      });
    });
  };

});
</script>
@stop


