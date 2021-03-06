@extends('Index.master')
@section('title') 班级公告详情 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="cl tabtool" style="margin-bottom:10px;">
         <span class="vm tab-bar"></span>
         <span class="vm tab-title-prev">
         	<a href="/classes?@if(!empty($query['column_id']))column_id={{$query['column_id']}}@endif">我的班级</a>
         	<span>&nbsp;&gt;&nbsp;</span>
         </span>
         <span class="vm tab-title-prev">
         	<a href="/classes/{{$query['class_id']}}@if(!empty($query['column_id']))?column_id={{$query['column_id']}}@endif">{{$info->classes->name}}</a>
         	<span>&nbsp;&gt;&nbsp;</span>
         </span>
         <span class="vm tab-title-prev">
         	<a href="/classes_notice/showList?class_id={{$query['class_id']}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">班级公告</a>
         	<span>&nbsp;&gt;&nbsp;</span>
         </span>
         <span class="vm">
             <span class="tab-title">{{$info->title}}</span>
         </span>
      </div>
      
      <div class="notice-detail">
	    <div style="padding:20px;">
		  <div class="notice-tit" style="color:#000;font-weight:bold;">{{$info->title}}</div>
	      <div class="notice-info">
	      	<span class="faq-time">{{$info->created_at}}</span>
	      	<span style="margin-left:30px;">浏览量：{{$info->visits or '0'}}</span>
	      	<span style="margin-left:30px;">评论：{{$info->commentcount->count()}}</span>
	      </div>
	      <div class="notice-sp"></div>
	      <div class="notice-con">{{$info->content}}</div>
	    </div>
      </div>

      <div class="notice-comment">
      	<div class="notice-comment-total">评论：（共{{$info->commentcount->count()}}条）
      	    <span style="color:#F97E7E;font-weight:normal;">注：发布不友善言论或反动言论一律永久封号！严重者将追究法律责任！</span>
      	</div>
      	
      	{{-- 评论form --}}
        <form method="post" action="/classes_notice/doComment" style="margin-bottom:40px;">
            <input type='hidden' name="notice_id" value="{{$info->id}}" />
            <input type='hidden' name="class_id" value="{{$query['class_id']}}" />
            <input type='hidden' name="column_id" value="{{$query['column_id']}}" />
            <textarea name="content" class="notice-comment-body" maxlength="250"></textarea>
            <br>
            <input type="submit" class="notice-comment-btn" value="提交评论" />
            <span style="font-size:13px;">(限250字)</span>
        </form>
        
        {{-- 回复form(隐藏) --}}
		<form style="display:none;" id="replyform" method="post" action="/classes_notice/doComment">
            <input type='hidden' name="notice_id" value="{{$info->id}}" />
            <input type='hidden' name="class_id" value="{{$query['class_id']}}" />
            <input type='hidden' name="column_id" value="{{$query['column_id']}}" />
            <input type='hidden' name="parent_id" value="" />
            <input type='hidden' name="content" value="" />
        </form>
        
        @foreach($comments as $k => $comment)
        <div name="comment-line" class="cl notice-comment-line">
        	<div style="float:left;">
        		<img src="{{Attachments::getAvatar($comment->uid)}}" class="notice-comment-avatar" />
        	</div>
        	<div class="cl notice-comment-info" style="float:left;">
        		<div class="cl">
        			<span style="color:#54b5e0;">
        			@if($comment->user && $comment->user->name)
        				@if($comment->user->name == 'admin')
        				客服雯雯
        				@elseif($comment->user->id == Session::get('uid'))
        				{{$comment->user->name}}(我)
        				@elseif($comment->user->id == $comment->classes->teacherid)
        				{{$comment->user->name}}(老师)
        				@else
        				{{$comment->user->name}}
        				@endif
        			@endif
        			</span> 
        			<span class="created_at" style="margin-left:10px;">{{$comment->created_at or '0'}}</span> 说：
	        		<span class="notice-floor">
	        			{{$floornums[$comment->id]}}
	        		</span>
        		</div>
        		
        		{{-- 引用 --}}
        		@if($comment->cite && $comment->cite->content)
				<span class="notice-reply-link" style="float:right;margin-top:-20px;" 
	        			onclick="toggleReply(event, 'reply1')">回复</span>
	            @if($comment->cite->classes && $comment->cite->classes->teacherid == Session::get('uid'))
				<span class="notice-reply-link" style="float:right;margin-top:-20px;margin-right:45px;" title="删除该条评论"
	        	    onclick="location.href='/classes_notice/doCommentDel?comment_id={{$comment->id}}&notice_id={{$info->id}}&class_id={{$query['class_id']}}&column_id={{$query['column_id']}}'">
	        	    删除评论</span>
	        	@endif
	        	<div name="reply1" style="margin-bottom:10px;text-align:right;display:none;">
	        		<textarea class="notice-comment-body" maxlength="250" style="width:600px;margin-top:5px;"></textarea>
	        		<input type="hidden" value="{{$comment->id}}">
	        		<div style="text-align:right;">
	        			<input type="button" class="notice-reply-btn" value="提交回复" onclick="doReply(event,'reply1')" />
	        		</div>
	        	</div>
	        	
        		<div class="cl notice-cite">
	        		<span style="color:#54b5e0;">
        			@if($comment->cite->user && $comment->cite->user)
        				@if($comment->cite->user->name == 'admin')
        				客服雯雯
        				@elseif($comment->cite->user->id == Session::get('uid'))
        				{{$comment->cite->user->name}}(我)
        				@elseif($comment->cite->user->id == $comment->cite->classes->teacherid)
        				{{$comment->cite->user->name}}(老师)
        				@else
        				{{$comment->cite->user->name}}
        				@endif
        			@endif
	        		</span>
	        		{{$comment->cite->created_at}} 发表在 
	        		<span style="color:#54b5e0;">{{$floornums[$comment->cite->id]}} 楼</span>
	        		<br>
	        		{{$comment->cite->content}}
	        		<br>
        			<span class="notice-cite-end">&nbsp;</span>
        		</div>
        		@endif
        		
        		<div class="cl" style="margin-top:5px;">
        			<span style="word-wrap:break-word;">{{$comment->content}}</span>
        			@if(empty($comment->cite))
					<span class="notice-reply-link" style="float:right;"
	        			onclick="toggleReply(event, 'reply2')">回复</span>
	        		@if($comment->classes && $comment->classes->teacherid == Session::get('uid'))
					<span class="notice-reply-link" style="float:right;margin-right:20px;" title="删除该条评论"
	        			onclick="location.href='/classes_notice/doCommentDel?comment_id={{$comment->id}}&notice_id={{$info->id}}&class_id={{$query['class_id']}}&column_id={{$query['column_id']}}'">
	        			删除评论
	        		</span>
	        		@endif
        			@endif
        		</div>
        	</div>
        	<div name="reply2" class="notice-reply-area" style="float:right;display:none;">
        		<textarea class="notice-comment-body" maxlength="250" style="width:600px;"></textarea>
        		<input type="hidden" value="{{$comment->id}}">
        		<div style="text-align:right;">
        			<input type="button" class="notice-reply-btn" value="提交回复" onclick="doReply(event,'reply2')" />
        		</div>
        	</div>
        </div>
        {{-- 分隔线 --}}
        <div style="margin-right:20px;border-bottom:1px dotted #c9c9c9;"></div>
        @endforeach
        
		<div style="text-align:right;margin-top:20px;">
			{{$comments->appends($query)->links()}}
		</div>
      </div>
      
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript">

/**
 * 获取时间与当前时间差(秒)
 */
function GetTimeDiff(time) {
	var startTime = time.replace(/\-/g, "/");
	var sTime = new Date(startTime).getTime();
	if(isNaN(sTime)) {
		return 0;
	}
	var eTime = new Date().getTime();
	if(sTime >= eTime) {
		return 0;
	}
	return (eTime-sTime) / 1000;
}

/**
 * 显示为多久前
 */
function GetDisplayDiff(time) {
	var ONE_DAY = 24*60*60;
	var ONE_HOUR = 60*60;
	var ONE_MIN = 60;
	var diff = GetTimeDiff(time);
	if(diff >= ONE_DAY) {
		diff = parseInt(diff / ONE_DAY);
		return diff+'天前';
	} else if(diff >= ONE_HOUR) {
		diff = parseInt(diff / ONE_HOUR);
		return diff+'小时前';
	} else if(diff >= ONE_MIN) {
		diff = parseInt(diff / ONE_MIN);
		return diff+'分钟前';
	} else {
		return parseInt(diff)+'秒前';
	}
}

// 修改评论时间为多久前
$('span.created_at').each(function() {
	var $cur = $(this);
	$cur.html(GetDisplayDiff($cur.html()));
});

// 修改帮助时间
$('span.faq-time').each(function() {
	var $cur = $(this);
	var time = $cur.html();
	if(time != '') {
		var d = new Date(time.replace(/\-/g, "/"));
		if(d) {
			var str = (d.getMonth()+1) + '月' + (d.getDate()) + '日';
			$cur.html(str);
		}
	}
});

/**
 * 切换显示回复框
 */
function toggleReply(event, replyName) {
	var $elem = $(event.target);
	var $commentLine = $elem.parents('div[name="comment-line"]');
	var $reply = $commentLine.find('div[name="'+replyName+'"]');
	$reply.toggle(function() {
		var $cur = $(this);
		var hide = $cur.is(":hidden");
		if(hide) {
			$elem.html('回复');
		} else {
			$elem.html('关闭回复');
		}
	});
}

/**
 * 发表回复
 */
function doReply(event, replyName) {
	var $reply = $(event.target).parents('div[name="'+replyName+'"]');
	var parent_id = $reply.find('input[type="hidden"]').val();
	var content = $reply.find('textarea').val();
	if(content == '') {
		return;
	}
	$('#replyform input[name="parent_id"]').val(parent_id);
	$('#replyform input[name="content"]').val(content);
	$('#replyform').submit();
}

</script>
@stop

