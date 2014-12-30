@extends('Index.master')
@section('title')错题记录 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
<div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
      <span class="tab-bar"></span>
      <span style="color:#499528;">错题记录</span>
      </div>
      <div class="clear"></div>

      <div class="fav-list">
          <table class="table-2" style="margin-top:0;" border="0" cellpadding="0" cellspacing="0">
          
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
                        <a class="fav-title" href="/topic?id={{$v->question->id}}&column_id={{$query['column_id']}}&from=fail" target="_blank">{{$v->question->txt}}</a>
                      @endif
                    </td>

                    <td width="80">
                      @if(!empty($v->question->type))
                      {{$typeEnum[$v->question->type]}}
                      @endif
                    </td>

                    <td class="tytd table-2-del"><a href="/failTopic/del?column_id={{$query['column_id']}}&id={{$v->id}}" class="tyadel">删除</a></td>
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
          </div>
            
          <div class="clear"></div>
      </div>
      
      <div style="text-align:center;">
		{{$list->appends($query)->links()}}
	  </div>
  </div>
  <div class="clear"></div>

</div> <!-- /container -->
</div> <!-- /container -->
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
	window.location.href = '/failTopic/del?ids=' + ids.join(',') + '&column_id=' + {{$query['column_id']}};
}

</script>
@stop


