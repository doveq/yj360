@extends('Index.master')
@section('title') 班级公告  @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">

  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
	  <div class="cl tabtool" style="margin-bottom:10px;">
      	 <a style="color:#999999;display:none;" href="/classes_notice/showList?class_id={{$query['class_id']}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">
      		<span class="fsort-back"></span>&nbsp;&nbsp;返回
      	 </a>
	     <span class="vm tab-bar"></span>
	     <span class="vm tab-title-prev">
	     	<a href="/classes?@if(!empty($query['column_id']))column_id={{$query['column_id']}}@endif">我的班级</a>
	     	<span>&nbsp;&gt;&nbsp;</span>
	     </span>
	     @if($classes && $classes->name)
	     <span class="vm tab-title-prev">
	     	<a href="/classes/{{$query['class_id']}}@if(!empty($query['column_id']))?column_id={{$query['column_id']}}@endif">{{$classes->name}}</a>
	     	<span>&nbsp;&gt;&nbsp;</span>
	     </span>
	     @endif
	     <span class="vm tab-title-prev">
	     	<a href="/classes_notice/showList?class_id={{$query['class_id']}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">班级公告</a>
	        <span>&nbsp;&gt;&nbsp;</span>
	     </span>
	     <span class="vm">
	     	<a class="tab-title">{{$mode}}</a>
	     </span>
	  </div>
  
      <div style="padding:10px;">
          <form action="/classes_notice/doEdit" method="post">
          	  <input type="hidden" name="id" value="@if(!empty($query['id'])){{$query['id']}}@endif"> 
          	  <input type="hidden" name="class_id" value="{{$query['class_id']}}"> 
          	  <input type="hidden" name="column_id" value="@if(!empty($query['column_id'])){{$query['column_id']}}@endif"> 
			  <div style="margin-bottom:10px;display:none;">
	          	<label>序号：</label>
	          	<input name="ordern" type="text" 
	          		style="width:50px;border:1px solid #c9c9c9;padding:2px 5px;" maxlength="6" 
	          		onkeyup="this.value=this.value.replace(/\D/g,'')"
	          		value="@if(!empty($notice)){{$notice->ordern}}@endif">
	          	<span style="color:#c9c9c9;font-size:13px;">（序号越小，排序越靠前）</span>
	          </div>
			  <div>
	          	<label>标题：</label>
	          	<input name="title" type="text" 
	          		style="width:500px;border:1px solid #c9c9c9;padding:2px 5px;" maxlength="100" 
	          		value="@if(!empty($notice)){{$notice->title}}@endif">
	          </div>
	          <div class="cl" style="margin-top:10px;">
	          	<label style="float:left;">正文：</label>
	          	<textarea rows="5" id="content" name="content" 
	          		style="float:left;width:93%;margin-left:5px;">@if(!empty($notice)){{$notice->content}}@endif</textarea>
	          </div>
	          <div style="margin-top:10px;">
	          	<input type="submit" value="提 交" class="notice-comment-btn" style="width:70px;margin-left:50px;">
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


