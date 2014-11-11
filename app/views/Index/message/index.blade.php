@extends('Index.master')
@section('title')我的消息 @stop

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
          <a href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          <table class="stable" border="0" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th>序号</th>
            <th>消息内容</th>
            <th>发送时间</th>
            <th>发送人</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          @if ($list->status == 0)
          <tr style="font-weight:bold" id="message_{{$list->id}}">
          @else
          <tr id="message_{{$list->id}}">
          @endif
            <td>{{$list->id}}</td>
            <td>{{str_limit($list->content, 10, '...')}}</td>
            <td>{{$list->created_at}}</td>
            <td>{{$list->sender->name}}</td>
            <td><a href="/message/{{$list->id}}?column_id={{$query['column_id']}}">查看</a> <a href="javascript:;" onClick="delete_message('{{$list->id}}');">删除</a></td>
          </tr>
          @endforeach
          <tr style="text-align:center">
            <td colspan="5">
                        {{$lists->appends($query)->links()}}
            </td>
          </tr>
        </tbody>
      </table>
          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript">
$(function(){
  delete_message = function(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/message/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $('#message_'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  };
});
</script>
@stop


