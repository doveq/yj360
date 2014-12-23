@extends('Index.master')
@section('title')我的班级@stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
    <div class="tabtool">
	  <a style="color:#999999;" href="/classes?column_id={{$query['column_id']}}">
      		<span class="fsort-back"></span>&nbsp;&nbsp;返回
      </a>
      <span class="tab-bar"></span>
      <a style="color:#499528;" href="/classes?column_id={{$query['column_id']}}">我的班级</a> > 
      <span class="tab-title">{{$classes->name}}</span>
      <span class="tab-btn">
      	<a href="/classes_notice/showList?column_id={{$query['column_id']}}&class_id={{$classes->id}}" class="tabtool-btn">班级公告({{$classes->noticescount()}})</a>
      
        @if ($classes->teacher->id == Session::get('uid'))
        <a href="/classes/mates?class_id={{$classes->id}}&column_id={{$query['column_id']}}" class="tabtool-btn">成员管理</a>
        @else
        <a href="javascript:;" class="quit_class tabtool-btn" onclick="quit_class({{$classmate[0]->id}});">退出班级</a>
        @endif
      </span>
    </div>

    <div class="classmate-list">
      <div class="classmate-box">
        @if ($classes->message > 0)
        <div class="classmate-msg"><span>{{$classes->message}}</span></div>
        @endif
        <div class="classmate-bzr"></div>
        <div class="classmate-head" style="height:120px;">
          @if ($classes->teacher->id == Session::get('uid'))
          <img src="{{Attachments::getAvatar($classes->teacher->id)}}" width="120px" height="120px"/>
          @else
          <a href="/message/talk?column_id={{$query['column_id']}}&user_id={{$classes->teacher->id}}&class_id={{$classes->id}}">
            <img src="{{Attachments::getAvatar($classes->teacher->id)}}" width="120px" height="120px"/>
          </a>
          @endif
        </div>
        <div class="classmate-title">
          @if ($classes->teacher->id == Session::get('uid'))
          <span class="classmate-name" style="color:#ff0000;">{{$classes->teacher->name}}(我)</span>
          @else
          <span class="classmate-name" style="color:#ff0000;">{{$classes->teacher->name}}</span>
          @endif
        </div>
      </div>
      @if ($students->count() > 0)
      @foreach ($students as $list)
      <div class="classmate-box">
        @if ($list->message > 0)
        <div class="classmate-msg"><span>{{$list->message}}</span></div>
        @endif
        <div class="classmate-head">
          @if ($list->id == Session::get('uid'))
          <img src="{{Attachments::getAvatar($list->id)}}" width="120px" height="120px"/>
          @else
          <a href="/message/talk?column_id={{$query['column_id']}}&user_id={{$list->id}}&class_id={{$classes->id}}">
            <img src="{{Attachments::getAvatar($list->id)}}" width="120px" height="120px"/>
          </a>
          @endif
        </div>
        <div class="classmate-title">
          @if ($list->id == Session::get('uid'))
          <span class="classmate-name">{{$list->name}}(我)</span>
          @else
          <span class="classmate-name">{{$list->name}}</span>
          @endif
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</div> <!-- /container -->
<div class="clear"></div>
</div>
@stop

@section('js')
<script type="text/javascript">
function quit_class(classmateid)
  {
    $.ajax({
      url:'/classmate/'+classmateid,
      data: {status: status},
      // async:false,
      type:'delete',
    })
    .fail(function(){
      alert('操作失败');
    })
    .success(function(){
      // alert(update_status);
      // $this.attr('data-status', update_status);
      // $this.text(status_txt)
      // location.reload();
      window.location.replace("/classes?column_id={{$query['column_id']}}");
    });
  }

  function delete_classmate(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/classmate/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){
        alert('操作失败');
      })
      .success(function(){
        $('#'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  }



</script>
@stop



