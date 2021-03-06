@extends('Index.master')
@section('title'){{$typeEnum[$query['type']]}} @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">

  <div class="cl tabtool" style="background-color:#fff;margin-bottom:0;border:0;">
     <span class="vm faq-tabbar"></span>
     <span class="vm">
         <a style="color:#c9c9c9;" href="/">首页</a>
         <span style="color:#c9c9c9;">&nbsp;&gt;&nbsp;</span>
     </span>
     <span class="vm tab-title">
     	<a style="color:#c9c9c9;" href="javascript:void(0);">帮助中心</a>
     	<span style="color:#c9c9c9;">&nbsp;&gt;&nbsp;</span>
     </span>
     <span class="vm tab-title">
     	<a style="color:#499528;" 
     	    href="/notice/list?type={{$query['type']}}">{{$typeEnum[$query['type']]}}</a>
     </span>
  </div>

  <div class="row">
    @include('Index.notice.nav')

  <div class="wrap-right">
      <div class="notice-list">
          @if(!empty($list))
          @foreach($list as $v)
          <div class="notice-item">
            <div class="notice-lt">
            	<li style="margin-left:15px;">
            	    <a style="color:#000;font-weight:bold;margin-left:-5px;" href="/notice/show?type={{$query['type']}}&id={{$v->id}}">{{$v->title}}</a>
            	</li>
            </div>
            <div class="notice-lc" style="display:none;">{{str_limit(strip_tags($v->content), $limit = 100, $end = '...')}}</div>
            <ul class="notice-tools">
              <li class="notice-tools-t" style="margin-top:5px;">
	              <span class="faq-time">{{$v->created_at}}</span>
	              <span style="margin-left:30px;">浏览量：{{$v->visits or '0'}}</span>
	              <span style="margin-left:30px;">评论：{{count($v->commentcount)}}</span>
	              <span style="margin-left:30px;">
	              	<a style="color:#499528;" href="/notice/show?type={{$query['type']}}&id={{$v->id}}">[查看全文]</a>
	              </span>
              </li>
            </ul>
          </div>
          <div class="notice-sp"></div>
          @endforeach

          <div style="text-align:right;">
            {{$list->appends($query)->links()}}
          </div>
          @endif
      </div>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript">

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

</script>
@stop


