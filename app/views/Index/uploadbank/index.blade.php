@extends('Index.master')
@section('title')原创题库 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        原创题库
        <a href="/uploadbank/create?column_id={{$query['column_id']}}" class="tabtool-btn">上传题库</a>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
        <div style="margin:10px;">你已经上传了{{$lists->count()}}个题库</div>
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
              <td><a href="javascript:void(0);" onClick="delete_uploadbank('{{$list->id}}');">删除</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
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


