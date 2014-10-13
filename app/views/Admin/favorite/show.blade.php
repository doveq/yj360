@extends('Admin.master_column')
@section('title')站点消息@stop

@section('nav')
  @include('Admin.message.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.message.index', '站点消息')}}</li>
      <li class="active">浏览消息</li>
    </ol>
  </div>

  <div class="row">
    <table class="table">
      <tr>
        <td class="text-right">发送者: </td>
        <td>{{$message->sender->name}}</td>
      </tr>
      <tr>
        <td class="text-right">发送时间: </td>
        <td>{{$message->created_at}}</td>
      </tr>
      <tr>
        <td class="text-right col-md-2">内容: </td>
        <td><p>{{nl2br(htmlentities($message->content))}}</p></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <a class="btn btn-xs btn-danger btn_delete" data-toggle="modal" data-id="{{$message->id}}"><i class="icon-trash"></i> 删除</a>
        </td>
      </tr>
      <tr>
        <td class="text-right">回复: </td>
        <td>
          {{ Form::open(array('url' => '/admin/message/','role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
          {{ Form::hidden('id', $message->id) }}
          {{ Form::hidden('type', $message->type) }}
          {{ Form::hidden('receiver_id', $message->sender_id) }}
          {{ Form::textarea('content', '', array('class' => 'form-control', 'rows' => 3)) }}
          {{ Form::button('发送', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
          {{ Form::close() }}

        </td>
      </tr>
    </table>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'message_id')) }}
    {{ Form::hidden('_method', '', array('id' => 'form_method')) }}

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body" id="myModalBody">
        </div>
        <div class="modal-footer">
          {{ Form::button('取消', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
          {{ Form::button('确定', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>

@stop

@section('js')
<script type="text/javascript">

$(function(){

  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var message_id = $this.data("id");
      if (message_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#message_id").val(message_id);
      $("#myModalForm").attr('action', '/admin/message/'+ message_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop