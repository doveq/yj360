@extends('Index.master')
@section('title')重点训练 @stop

@section('content')
<div class="container-column wrap">
  <div class="wrap-left">
      <div class="sort">
          <div class="sort-tit">全部分类</div>
          <div class="sort-bb"></div>
          <ul class="sort-list">
            @foreach($columns as $k => $column)
            <li><a href="/column?id={{$column->id}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          @if (Session::get('utype') == 1)
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj sort-wbj-act"><a href="/uploadbank?column_id={{$query['column_id']}}">原创题库</a><div class="sort-sj"></div></div>
          @endif
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd"><a href="#">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

  <div class="wrap-right">
      <div class="tabtool">
        你已经上传了{{$lists->count()}}个题库
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
        <table  class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>序号</th>
              <th>题库名称</th>
              <th>发送时间</th>
              <th>上传人</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lists as $list)
            <tr id="bank_{{$list->id}}">
              <td>{{$list->id}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->created_at}}</td>
              <td>{{$list->user->name}}</td>
              <td>查看 <a href="javascript:;" onClick="delete_uploadbank('{{$list->id}}');">删除</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
  delete_uploadbank = function(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/uploadbank/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $('#bank_'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  }

});
</script>
@stop


