@extends('Index.master')
@section('title') 班级消息  @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">

  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
	  <div class="cl tabtool" style="background-color:#fff;margin-bottom:0;border:0;">
      	 <a style="color:#999999;" href="/classes?column_id=@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">
      		<span class="fsort-back"></span>&nbsp;&nbsp;返回
      	 </a>
	     <span class="vm faq-tabbar" style="margin-left:10px;"></span>
	     <span class="vm">
	     	<a style="color:#499528;" href="/classes?@if(!empty($query['column_id']))column_id={{$query['column_id']}}@endif">我的班级</a>
	     	<span style="color:#499528;">&nbsp;&gt;&nbsp;</span>
	     </span>
	     @if($classes && $classes->name)
         <span class="vm tab-title">
         	<a style="color:#499528;" href="/classes/{{$query['class_id']}}@if(!empty($query['column_id']))?column_id={{$query['column_id']}}@endif">{{$classes->name}}</a>
         	<span style="color:#499528;">&nbsp;&gt;&nbsp;</span>
         </span>
         @endif
	     <span class="vm tab-title" style="color:#000;">
	     	班级消息
	     </span>
	     <span style="float:right;">
	     	<a href="/classes_notice/create?class_id={{$query['class_id']}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif" class="tabtool-btn">发布消息</a>
	     </span>
	  </div>
  
      <div class="notice-list">
          @if(!empty($cnList) && count($cnList)!=0)
          @foreach($cnList as $v)
          <div class="notice-item">
            <div class="notice-lt">
            	<a style="color:#000;font-weight:bold;" href="/classes_notice/show?id={{$v->id}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">{{$v->title}}</a>
            </div>
            <div class="notice-lc">{{str_limit(strip_tags($v->content), $limit = 100, $end = '...')}}</div>
            <ul class="notice-tools">
              <li class="notice-tools-t" style="margin-top:5px;">
	              <span class="faq-time">{{$v->created_at}}</span>
	              <span style="margin-left:30px;">评论：{{$v->commentcount->count()}}</span>
	              <span style="margin-left:30px;">
	              	<a style="color:#499528;" href="/classes_notice/show?id={{$v->id}}&class_id={{$query['class_id']}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">[查看全文]</a>
	              </span>
	              @if($v->classes && $v->classes->teacherid==Session::get('uid'))
				  <span style="margin-left:30px;">
	              	<a style="color:#499528;" href="/classes_notice/edit?class_id={{$query['class_id']}}&id={{$v->id}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">[编辑]</a>
	              </span>
				  <span style="margin-left:30px;">
	              	<a style="color:#499528;" href="/classes_notice/doDel?class_id={{$query['class_id']}}&id={{$v->id}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif">[删除]</a>
	              </span>
	              @endif
              </li>
            </ul>
          </div>
          <div class="notice-sp"></div>
          @endforeach

          <div style="text-align:right;">
            {{$cnList->appends($query)->links()}}
          </div>
          @else
          <span>暂时没有班级消息</span>
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


