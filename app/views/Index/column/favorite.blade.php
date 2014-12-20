@extends('Index.master')
@section('title')我的收藏 @stop

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
      <span class="tab-bar"></span>
      <span style="color:#499528;">我的收藏（共{{count($list)}}条）</span>
      <span style="float:right;">
      	<a class="tabtool-btn" style="font-weight:600;" href="/favorite/sort?column_id={{$query['column_id']}}">管理收藏夹</a>
      </span>
      </div>
      <div class="clear"></div>

      <div>
      
      <a 
      	@if($query['sort'] === null)
      		class="fsort-title on" 
      	@else 
      		class="fsort-title" 
      	@endif 
      	href="/favorite?column_id={{$query['column_id']}}">
      	全部收藏
      </a>
      
      <a 
        @if($query['sort'] === '0')
      		class="fsort-title on"
      	@else
      		class="fsort-title"
      	@endif
      	href="/favorite?column_id={{$query['column_id']}}&sort=0">默认收藏</a>
      
      @if(!empty($slist))
      @foreach($slist as $k => $v)
        <a
        @if($query['sort'] == $v->id)
        	class="fsort-title on"
        @else
        	class="fsort-title"
        @endif	
        href="/favorite?column_id={{$query['column_id']}}&sort={{$v->id}}" title="{{$v->name}}">
         <span class="fsort-title-text">{{$v->name}}</span>
        </a>
      @endforeach
      @endif
      
      <a class="fsort-new" href="javascript:void(0);" onclick="newSort();">+新建收藏夹</a>
      </div>

      <div class="fav-list">
          <table class="table-2" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:30px;"></td>
            <td style="padding:10px 0;font-size:15px;font-weight:600;">序号</td>
            <td style="padding:10px 0;font-size:15px;font-weight:600;">标题</td>
            <td style="padding:10px 0;font-size:15px;font-weight:600;">所属分类</td>
            <td style="padding:10px 0;font-size:15px;font-weight:600;">操作</td>
          </tr>
            @if(!empty($list))
              @foreach($list as $k => $v)
                <tr>
                    <td>
                    	<input type="checkbox" value="{{$v->id}}" name="fid" />
                    </td>
                    <td class="tytd" style="color:#499528;font-family: Microsoft Yahei,Arial;font-size:15px;">
                    {{$k+1}}
                    </td>
                    <td class="tytd">
                      @if(empty($v->question->txt))
                       	 该题已下架
                      @else
                        <a class="fav-title" href="/topic?id={{$v->question->id}}&column_id={{$query['column_id']}}&from=favorite" target="_blank">{{$v->question->txt}}</a>
                      @endif
                    </td>
					<td class="tytd">
				      {{$typeEnum[$v->question->type] or ''}}
                    </td>
                    <td class="tytd table-2-del"><a href="/favorite/del?column_id={{$query['column_id']}}&qid={{$v->question->id}}" class="tyadel">删除</a></td>
                </tr>
              @endforeach
            @endif
          </table>

          <div class="cl">
            <div style="float:left;font-size:13px;">
            	<input id="check-all" type="checkbox" style="margin-left:10px;vertical-align:middle;" onclick="checkAll(event)">
            	<label for="check-all" style="vertical-align:middle;">全选</label>
            	
            	<input id="invert-check" type="checkbox" style="margin-left:10px;vertical-align:middle;" onclick="invertCheck()">
            	<label for="invert-check" style="vertical-align:middle;">反选</label>
            	
            	<span style="margin-left:10px;vertical-align:middle;cursor:pointer;" onclick="deleteCheck()">批量删除</span>
            </div>
            
            @if(count($slist)!=0)
            <div style="float:left;margin-left:20px;">
	            <select name="msort" class="vm" style="font-size:13px;">
	              @foreach($slist as $k => $v)
	                <option value="{{$v->id}}" title="{{$v->name}}">
	                	<span>@if(strlen($v->name)>20){{substr($v->name,0,20).'...'}}@else{{$v->name}}@endif</span>
	                </option>
	              @endforeach
	            </select>
	            <a class="vm fav-move-btn" style="margin-left:0;" href="javascript:void(0);" onclick="moveCheck()">批量移动</a>
            </div>
            @endif
          </div>
      </div>
      
      <div style="text-align:center;">
		{{$list->appends($query)->links()}}
	  </div>
  </div>
  <div class="clear"></div>

</div> <!-- /container -->
</div> <!-- /container -->

<div id="fsort-add" style="display:none;">
    <div class="fsort-box">
      <form action="/favorite/sort/doAdd" method="post">
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

@stop

@section('js')
<script type="text/javascript">

/**
 * 全选
 */
function checkAll(event) {
	var $cur = $(event.target);
	$('input[name="fid"]').prop('checked', $cur.prop('checked'));
}

/**
 * 反选
 */
function invertCheck() {
	$('input[name="fid"]').each(function() {
		var $cur = $(this);
		if($cur.prop('checked') == true) {
			$cur.prop('checked', false);
		} else {
			$cur.prop('checked', true);
		}
	});
}

/**
 * 获取选中记录id
 */
function getCheckIds() {
	var ids = [];
	$('input[name="fid"]').each(function() {
		var $cur = $(this);
		if($cur.prop('checked') == true) {
			ids.push($cur.val());
		}
	});
	return ids;
}

/**
 * 批量删除
 */
function deleteCheck() {
	var ids = getCheckIds();
	if(ids.length == 0) {
		return;
	}
	window.location.href = '/favorite/del?ids=' + ids.join(',') + '&column_id=' + {{$query['column_id']}};
}

/**
 * 批量移动
 */
function moveCheck() {
	var ids = getCheckIds();
	if(ids.length == 0) {
		return;
	}
	var msort = $('select[name="msort"]').val();
	if(!msort) {
		return;
	}
	window.location.href = '/favorite/move?ids=' + ids.join(',') + '&column_id=' + {{$query['column_id']}} + '&msort=' + msort;
}

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


