@extends('Index.master')
@section('title') 班级消息群发  @stop
@extends('Index.column.columnHead')

@section('css')
<style>
.msg-label {
	display: inline-block;
	width: 70px;
	text-align: right;
}
</style>
@stop

@section('content')
<div class="container-column wrap">

  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
	  <div class="cl tabtool" style="margin-bottom:10px;">
	     <span class="vm tab-bar"></span>
	     <span class="vm tab-title-prev">
	     	<a href="/classes?column_id={{$query['column_id']}}">我的班级</a>
	     	<span>&nbsp;&gt;&nbsp;</span>
	     </span>
	     @if($classes && $classes->name)
	     <span class="vm tab-title-prev">
	     	<a href="/classes/{{$query['class_id']}}?column_id={{$query['column_id']}}">{{$classes->name}}</a>
	     	<span>&nbsp;&gt;&nbsp;</span>
	     </span>
	     @endif
	     <span class="vm">
	     	<a class="tab-title">班级消息群发</a>
	     </span>
	  </div>
  
      <div style="padding:5px 10px;">
          <form id="batchmsgform" action="/classes_notice/dobatchmsg" method="post">
          	  <input type="hidden" name="class_id" value="{{$query['class_id']}}"> 
          	  <input type="hidden" name="column_id" value="{{$query['column_id']}}">
          	  <div class="cl" style="display:none;">
          	      <label class="msg-label" style="float:left;">接收人：</label>
          	      <div style="float:left;width:90%;margin-left:5px;">
                  	  <input id="checkAll" type="checkbox" class="vm" style="margin-left:5px;">
                  	  <label class="vm" for="checkAll">全选</label>
                  	  <br>
              	  
                  	  @if(!empty($students))
                  	  @foreach($students as $stu)
                  	  <input name="stu[]" type="checkbox" value="{{$stu->id}}" class="vm" style="margin-left:5px;">
                  	  <label class="vm">{{$stu->name}}</label>
                  	  @endforeach
                  	  @endif
              	  </div>
          	  </div>
	          <div class="cl" style="margin-top:10px;">
	          	<label class="msg-label" style="float:left;">消息内容：</label>
	          	<textarea rows="5" id="content" name="content" 
	          	    style="float:left;width:690px;margin-left:10px;padding:3px;"></textarea>
	          </div>
	          <div style="margin-top:10px;">
	          	<input type="submit" value="提 交" class="notice-comment-btn" style="width:70px;margin-left:80px;">
	          </div>
          </form>
      </div>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript">

// 全选或全不选
$('#checkAll').click(function() {
    $('input[name="stu[]"]').prop("checked", this.checked);
});

</script>
@stop

