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
                   我的收藏
                 （共{{$favcount}}条）

      <span style="float:right;"><a class="tabtool-btn" href="/favorite/sort?column_id={{$query['column_id']}}">管理收藏夹</a></span>
      </div>
      <div class="clear"></div>

      <div>
      
      <a 
      	@if($query['sort'] === null)
      		class="tabtool-btn fav-sort-title on" 
      	@else 
      		class="tabtool-btn fav-sort-title" 
      	@endif 
      	href="/favorite?column_id={{$query['column_id']}}">
      	全部收藏夹
      </a>
      
      <a 
        @if($query['sort'] === '0')
      		class="tabtool-btn fav-sort-title on"
      	@else
      		class="tabtool-btn fav-sort-title"
      	@endif
      	href="/favorite?column_id={{$query['column_id']}}&sort=0">默认分类</a>
      
      @if(!empty($slist))
      @foreach($slist as $k => $v)
        <a
        @if($query['sort'] == $v->id)
        	class="tabtool-btn fav-sort-title on"
        @else
        	class="tabtool-btn fav-sort-title"
        @endif	
        href="/favorite?column_id={{$query['column_id']}}&sort={{$v->id}}">
        {{$v->name}}
        </a>
      @endforeach
      @endif
      
      <a class="fav-sort-new" href="javascript:void(0);" onclick="newSort();">新建收藏夹</a>
      </div>

      <div class="classes-list">
          <table class="table-2" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;margin-bottom:50px;">
          <tr style="font-weight:bold;">
            <td></td>
            <td>序号</td>
            <td style="padding-left:25px;">标题</td>
            <td>所属分类</td>
            <td style="padding-left:15px;">操作</td>
          </tr>
          <tr>
            <td colspan="5">
            	<div style="margin-top:5px;border-top:1px solid #333;"></div>
            </td>
          </tr>
            @if(!empty($list))
              @foreach($list as $k => $v)
                <tr>
                    <td>
                    	<input type="checkbox" value="{{$v->id}}" name="fid" />
                    </td>
                    <td class="tytd">
                    {{$k+1}}
                    </td>
                    <td class="tytd">
                      @if(empty($v->question->txt))
                        该题已下架
                      @else
                        <a href="/topic?id={{$v->question->id}}&column_id={{$query['column_id']}}&from=favorite" target="_blank">{{$v->question->txt}}</a>
                      @endif
                    </td>
					<td class="tytd">
				      {{$sinfo[$v->sort] or '默认分类'}}
                    </td>
                    <td class="tytd table-2-del"><a href="/favorite/del?column_id={{$query['column_id']}}&qid={{$v->question->id}}" class="tyadel">删除</a></td>
                </tr>
                <tr><td colspan="5">
                    <div class="table-2-sp"></div>
                </td></tr>
              @endforeach
            @endif
          </table>

          <div>
            <a class="fav-btn" href="javascript:void(0);" onclick="checkAll()">全选</a>
            <a class="fav-btn" href="javascript:void(0);" onclick="invertCheck()">反选</a>
            <a class="fav-btn" href="javascript:void(0);" onclick="deleteCheck()">批量删除</a>

            @if(count($slist)!=0)
            <div style="float:right;">
	            <select name="msort">
	              @foreach($slist as $k => $v)
	                <option value="{{$v->id}}">{{$v->name}}</option>
	              @endforeach
	            </select>
	            <a class="fav-btn" style="margin-left:20px;" href="javascript:void(0);" onclick="moveCheck()">批量移动</a>
            </div>
            @endif
            
          </div>
          
          <div class="clear"></div>
          
          <div style="text-align:right;margin-top:20px;">
			{{$list->appends($query)->links()}}
		  </div>
      </div>
  </div>
  <div class="clear"></div>

</div> <!-- /container -->
</div> <!-- /container -->

<div id="fsort-add" style="display:none;">
    <div class="fsort-box">
      <form action="/favorite/sort/doAdd" method="post">
        <input type="hidden" name="column_id" value="{{$query['column_id']}}" />

        <div class="fsort-tit">创建收藏夹</div>
        <div class="fsort-con">
          	 收藏夹名称：<input type="text" name="name" value="" style="padding:5px;width:200px;" />
        </div>
        <div class="fsort-bot">
          <button class="fsort-btn fsort-btn-ok" type="submit">确定</button>
          <button class="fsort-btn" style="margin-left:10px;" onclick="closeSort();return false;">取消</button>
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
function checkAll() {
	$('input[name="fid"]').prop('checked', true);
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
        shadeClose: true,
        offset:['100px' , ''],
        shade: [0],
        border: [0],
        area : ['auto','auto'],
        page : {
            html: $("#fsort-add").html()
        }
    });
}

function closeSort() {
	if(layerSort == null) {
		return;
	}
	layer.close(layerSort);
}

</script>
@stop


