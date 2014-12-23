@extends('Index.master')
@section('title')我的班级@stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
    <div class="tabtool">
      <span class="tab-bar"></span>
      <a href="/classes?column_id={{$query['column_id']}}" class="tabtool-btn-back" style="display:none;">返回></a>
      <span class="tab-title-prev">
          <a href="/classes?column_id={{$query['column_id']}}">我的班级</a>
          <span>&nbsp;>&nbsp;</span>
      </span>
      <span class="tab-title">{{$classes->name}}</span>
      <span class="tab-btn">
        <a href="/classes/{{$classes->id}}?column_id={{$query['column_id']}}" class="tabtool-btn">返回班级</a>
      </span>
    </div>

    <div class="classmate-list">
      <div class="classmate-box">
        <div class="classmate-bzr"></div>
        <div class="classmate-head">
          @if ($classes->teacher->id == Session::get('uid'))
          <img src="{{Attachments::getAvatar($classes->teacher->id)}}" width="120px" height="120px"/>
          @else
          <a href="/message/talk?column_id={{$query['column_id']}}&user_id={{$classes->teacher->id}}&class_id={{$classes->id}}">
            <img src="{{Attachments::getAvatar($classes->teacher->id)}}" width="120px" height="120px"/>
          </a>
          @endif
        </div>
        <div class="classmate-title">
          <span class="classmate-name" style="color:#ff0000;">{{$classes->teacher->name}}</span>
        </div>
      </div>
      @if ($students->count() > 0)
      @foreach ($students as $list)
      <div class="classmate-box" id="classmate_{{$list->pivot->id}}">
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
          <!-- <span class="classmate-name">{{$list->name}}</span> -->
        </div>
         <div class="classse-btn" style="display:block;">
              <a class="delclass" href="javascript:;" onClick="delete_classmate('{{$list->pivot->id}}');">删除</a>
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
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  delete_classmate = function(id){
    layer.confirm('您确定要删除吗？', function(){
      $.ajax({
        url:'/classmate/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){
        layer.msg('删除失败', 2, 1);
      })
      .success(function(){
        layer.closeAll();
        $('#classmate_'+id).remove();
      });
    });
  };
});
</script>
@stop



