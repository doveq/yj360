@extends('Index.master')
@section('title'){{$typeEnum[$query['type']]}} @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">

  <div class="cl tabtool" style="background-color:#fff;margin-bottom:0;border:0;">
     <span class="vm faq-tabbar"></span>
     <span class="vm"><a style="color:#c9c9c9;" href="/">首页</a><span style="color:#c9c9c9;">&nbsp;&gt;&nbsp;</span></span>
     <span class="vm tab-title">
     	<a style="color:#499528;" href="/notice/list?column_id={{$query['column_id']}}&type=1">{{$typeEnum[1]}}</a>
     </span>
  </div>

  <div class="row">
    @include('Index.notice.nav')

  <div class="wrap-right">
      <div class="notice-list">
          @if(!empty($list))
          @foreach($list as $v)
          <div class="notice-item">
            <div class="notice-lt">{{$v->title}}</div>
            <div class="notice-lc" style="font-size:13px;">{{str_limit(strip_tags($v->content), $limit = 100, $end = '...')}}</div>
            <ul class="notice-tools">
              <li class="notice-tools-t" style="margin-top:5px;font-size:13px;">
	              <span class="faq-time">{{$v->created_at}}</span>
	              <span style="margin-left:30px;">评论：{{count($v->commentcount)}}</span>
	              <span style="margin-left:30px;">
	              	<a style="color:#499528;" href="/notice/show?type=1&id={{$v->id}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">[查看全文]</a>
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


