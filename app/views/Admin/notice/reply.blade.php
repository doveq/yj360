@extends('Admin.master_column')
@section('title')帮助反馈@stop

@section('nav')
  @include('Admin.notice.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/notice">帮助反馈</a></li>
      <li><a href="/admin/notice/comment?id={{$noticeid}}">查看评论</a></li>
      <li class="active">回复评论</li>
    </ol>
  </div>
  
  <div class="row">
	  <form class="form-horizontal" enctype="multipart/form-data" role="form" accept-charset="UTF-8" action="/admin/notice/doReply" method="POST">
	      <input name="commentid" value="{{$commentid}}" type="hidden" />
	      <input name="noticeid" value="{{$noticeid}}" type="hidden" />
	      <input name="tag" value="@if($tag){{$tag}}@endif" type="hidden" />
	      
	  	  <div class="form-group">
			  <label class="col-md-2 control-label" for="column_name">评论内容</label>
	          <div class="col-md-10" style="margin-top:7px;word-wrap:break-word;">
	          	{{$comment->content}}
	          </div>
	  	  </div>
	  	  <div class="form-group">
			  <label class="col-md-2 control-label" for="column_name">评论人</label>
	          <div class="col-md-10" style="margin-top:7px;word-wrap:break-word;">
	          	<span>{{$comment->user->name or '未知用户'}} </span>
	          	<span style="margin-left:20px;">{{$comment->created_at or ''}}</span>
	          </div>
	  	  </div>
	
	      <div class="form-group">
	          <label class="col-md-2 control-label" for="column_name">回复内容</label>
	          <div class="col-md-10">
	            <textarea rows="5" id="content" name="content"></textarea>
	          </div>
	      </div>
	
	      <div class="form-group">
	          <label class="col-sm-3 control-label"></label>
	          <div class="col-sm-9">
	              <button type="submit" class="btn btn-success">提交回复</button>
	          </div>
	        </div>
	      </form>
	  </form>
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
