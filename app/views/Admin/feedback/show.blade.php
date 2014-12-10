@extends('Admin.master_column')
@section('title')站点消息@stop

@section('nav')
  @include('Admin.feedback.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.feedback.index', '站点消息')}}</li>
      <li class="active">浏览消息</li>
    </ol>
  </div>

  <div class="row">
    <form enctype="multipart/form-data" method="POST" action="/admin/feedback/{{$feedback->id}}" >
    <input name="_method" type="hidden" value="PUT">
    <table class="table">
      <tr>
        <td class="text-right">反馈者: </td>
        <td>{{$feedback->user->name}}</td>
      </tr>
      <tr>
        <td class="text-right">反馈时间: </td>
        <td>{{$feedback->created_at}}</td>
      </tr>
      <tr>
        <td class="text-right">类型: </td>
        <td>{{$typeEnum[$feedback->type]}}</td>
      </tr>
      <tr>
        <td class="text-right col-md-2">内容: </td>
        <td><p>{{nl2br(htmlentities($feedback->content))}}</p></td>
      </tr>
      <tr>
        <td class="text-right col-md-2">回复: </td>
        <td>
            <textarea style="width:600px;" rows="5" name="reply">{{$feedback->reply}}</textarea>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <button type="submit" class="btn btn-primary">保存</button>
          <!--
          <a class="btn btn-xs btn-danger btn_delete" data-toggle="modal" data-id="{{$feedback->id}}"><i class="icon-trash"></i> 删除</a>
          -->
        </td>
      </tr>
    </table>
    </form>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'feedback_id')) }}
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
      var feedback_id = $this.data("id");
      if (feedback_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#feedback_id").val(feedback_id);
      $("#myModalForm").attr('action', '/admin/feedback/'+ feedback_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop