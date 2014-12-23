@extends('Index.master')
@section('title')班级管理 @stop
@extends('Index.column.columnHead')

@section('headjs')
<script src="/assets/layer/layer.min.js"></script>
@stop

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="cl tabtool">
      	<a style="color:#999999;" href="/classes?column_id={{$query['column_id']}}">
      		<span class="fsort-back"></span>&nbsp;&nbsp;返回
      	</a>
      	<span class="tab-bar" style="margin-left:15px;"></span>
        <span style="color:#499528;">
	        <a style="color:#499528;" href="/classes?column_id={{$query['column_id']}}">我的班级</a> > 
	        <a style="color:#499528;" href="/classes/manage?column_id={{$query['column_id']}}">班级管理</a>
        </span>
      </div>

      @if(!empty($classes))
      @foreach($classes as $k=>$v)
      <div class="cl fsort-line">
        <form action="/classes/manage/doEdit" method="post">
          <input type="hidden" name="id" value="{{$v->id}}" />
          <input type="hidden" name="column_id" value="{{$query['column_id']}}" />
          
          <div style="float:left;line-height:40px;">
          	<span class="fsort-num">{{$k+1}}</span>
            <input class="fsort-input" type="text" name="name" style="width:250px;" value="{{$v->name}}" maxlength="50" />
           	<span>（成员：@if($v) {{$v->students()->where('classmate.status', 1)->count()}} @else '0' @endif）</span>
          </div>

          <div style="float:right;line-height:40px;">
            <button type="button" class="manage-btn"
            	onclick="location.href='/classes/{{$v->id}}?column_id={{$query['column_id']}}'">成员管理</button>
            <button type="button" class="manage-btn" style="margin-left:5px;display:none;">班级转让</button>
            <button type="button" class="manage-btn" style="margin-left:5px;"
            	onclick="delClasses({{$v->id}})">删&nbsp;除</button>
            <button type="submit" class="manage-btn" style="margin-left:5px;">保&nbsp;存</button>
          </div>
        </form>
      </div>
      @endforeach
      
      <div>
      	<a class="fsort-new" href="/classes/create?column_id={{$query['column_id']}}&tag=manage">+创建班级</a>
      </div>
      
	  <div style="text-align:center;margin-top:20px;">
	  	{{$classes->appends($query)->links()}}
	  </div>
	  @endif
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>

<script type="text/javascript">

function delClasses(id) {
	layer.confirm('您确定要删除吗？', function() {
    	location.href='/classes/manage/doDel?id=' + id + '&column_id={{$query['column_id']}}';
	});
}

</script>

@stop


