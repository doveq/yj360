@extends('Index.master')
@section('title')收藏夹管理 @stop
@extends('Index.column.columnHead')

@section('headjs')
<script src="/assets/layer/layer.min.js"></script>
@stop

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
      	<a style="color:#999999;" href="/favorite?column_id={{$query['column_id']}}">
      		<span class="fsort-back"></span>&nbsp;&nbsp;返回
      	</a>
      	<span class="tab-bar" style="margin-left:15px;"></span>
        <span style="color:#499528;">我的收藏（共{{$favcount}}条）</span>
      </div>
      <div class="clear"></div>

      @if(!empty($slist))
      @foreach($slist as $k=>$v)
      <div class="clear fsort-line">
        <form action="/favorite/sort/doEdit" method="post" >
          <input type="hidden" name="id" value="{{$v->id}}" />
          <input type="hidden" name="column_id" value="{{$v->column_id}}" />
          
          <div style="float:left;">
          	<span class="fsort-num">{{$v->id}}</span>
            <input class="fsort-input" type="text" name="name" value="{{$v->name}}" maxlength="64" />
          </div>

          <div style="float:right;line-height:40px;">
            <button class="fsort-delete" type="button" 
            	onclick="location.href='/favorite/sort/doDel?id={{$v->id}}&column_id={{$v->column_id}}'"></button>
            <button class="fsort-save" style="margin-left:10px;" type="submit"></button>
          </div>
        
        </form>
      </div>
      <div class="clear"></div>
      @endforeach
      
      <div>
      	<a class="fsort-new" href="javascript:void(0);" onclick="newSort();">+新建收藏夹</a>
      </div>
      
	  <div style="text-align:center;margin-top:20px;">
		{{$slist->appends($query)->links()}}
	  </div>
      
      @endif
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>

<div id="fsort-add" style="display:none;">
    <div class="fsort-box">
      <form action="/favorite/sort/doAdd" method="post">
      	<input type="hidden" name="tag" value="sort" />
        <input type="hidden" name="column_id" value="{{$query['column_id']}}" />

        <div class="cl fsort-tit">
            <span>创建收藏夹</span>
            <span class="fsort-close" style="float:right;" onclick="closeSort();" title="关闭"></span>
        </div>
        <div class="fsort-con">
          	 收藏夹名称：<input type="text" name="name" value="" 
          	 style="padding:3px 5px;width:230px;height:30px;border:1px solid #c9c9c9;" maxlength="64" />
        </div>
        <div class="fsort-bot" style="border-top:none;">
          <button class="fsort-btn-ok" type="submit"></button>
          <button class="fsort-btn-cancel" style="margin-left:10px;" onclick="closeSort();return false;"></button>
        </div>
      </form>
    </div>
</div>

<script type="text/javascript">

var layerSort = null;

/**
 * 新建收藏夹
 */
function newSort() {
	layerSort = $.layer({
        type : 1,
        title : false,
        offset:['100px' , ''],
        closeBtn: [0, false],
        shade: [0],
        border: [0],
        area : ['auto','auto'],
        page : {
            html: $("#fsort-add").html()
        }
    });
}

function closeSort() {
	layer.close(layerSort);
}

</script>

@stop


