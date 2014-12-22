@extends('Index.master')
@section('title') 班级消息  @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">

  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
	  <div class="cl tabtool" style="background-color:#fff;margin-bottom:0;border:0;">
      	 <a style="color:#999999;" href="/classes/showList?class_id={{$query['class_id']}}column_id=@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">
      		<span class="fsort-back"></span>&nbsp;&nbsp;返回
      	 </a>
	     <span class="vm faq-tabbar" style="margin-left:10px;"></span>
	     <span class="vm">
	     	<a style="color:#499528;" href="/classes?@if(!empty($query['column_id']))column_id={{$query['column_id']}}@endif">我的班级</a>
	     	<span style="color:#499528;">&nbsp;&gt;&nbsp;</span>
	     </span>
	     <span class="vm tab-title">
	     	<a style="color:#499528;" href="/classes_notice/showList?class_id={{$query['class_id']}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">班级消息</a>
	     </span>
	  </div>
  
      <div style="padding:10px;">
          <form action="/classes_notice/doEdit" method="post">
          	  <input type="hidden" name="id" value="@if(!empty($query['id'])){{$query['id']}}@endif"> 
          	  <input type="hidden" name="class_id" value="{{$query['class_id']}}"> 
          	  <input type="hidden" name="column_id" value="@if(!empty($query['column_id'])){{$query['column_id']}}@endif"> 
			  <div>
	          	<label>标题：</label>
	          	<input name="title" type="text" 
	          		style="width:500px;border:1px solid #c9c9c9;padding:2px 5px;" maxlength="100" 
	          		value="@if($notice){{$notice->title}}@endif">
	          </div>
	          <div class="cl" style="margin-top:10px;">
	          	<label style="float:left;">正文：</label>
	          	<textarea rows="5" id="content" name="content" 
	          		style="float:left;width:93%;margin-left:5px;">@if($notice){{$notice->content}}@endif</textarea>
	          </div>
	          <div style="margin-top:10px;">
	          	<input type="submit" value="提 交" 
	          		style="margin-left:50px;width:70px;padding:2px 5px;border:1px solid #c9c9c9;cursor:pointer;">
	          </div>
          </form>
      </div>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript" src="/assets/ueditor/ueditor-notice.config.js"></script>
<script type="text/javascript" src="/assets/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
	var ue = UE.getEditor('content');
</script>
@stop


