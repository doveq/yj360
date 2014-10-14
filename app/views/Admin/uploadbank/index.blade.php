@extends('Admin.master_column')
@section('title')站点消息@stop

@section('nav')
  @include('Admin.uploadbank.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.uploadbank.index', '上传题库')}}</li>
      <li class="active">浏览消息</li>
    </ol>
  </div>

  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>上传者</th>
            <th>题库名称</th>
            <th>题库说明</th>
            <th>文件</th>
            <th>上传时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->user->name}}</td>
            <td>{{$list->name}}</td>
            <td>{{$list->desc}}</td>
            <td><a href="{{url('/admin/uploadbank/'.$list->id)}}"><i class="glyphicon glyphicon-download"> </i> {{$list->filename}}</a></td>
            <td>{{$list->created_at}}</td>
            <td>
              @if ($list->status == 1)
              <span class="label label-default">{{$statusEnum[$list->status]}}</span>
              @elseif ($list['status'] == 0)
              <span class="label label-info">{{$statusEnum[$list->status]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$list->status]}}</span>
              @endif
            </td>
            <td>
              <div class="btn-group btn-xs">
                @if ($list->status === 1)
                  <a class="btn btn-default btn-xs btn_publish disabled"><i class="glyphicon glyphicon-ok"></i></a>
                @else
                  <a class="btn btn-default btn-xs btn_publish" href="#" data-toggle="modal" data-id="{{$list->id}}" data-status="1"><i class="glyphicon glyphicon-ok"></i></a>
                @endif
                  <a class="btn btn-default btn-xs btn_delete" href="#" data-toggle="modal" data-id="{{$list->id}}" data-status="-1"><i class="glyphicon glyphicon-remove"></i></a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$lists->appends($query)->links()}}
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'uploadbank_id')) }}
    {{ Form::hidden('status', '', array('id' => 'uploadbank_status')) }}
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

  //发布,下线
  $(".btn_publish").bind("click", function(){
      var $this = $(this);
      var uploadbank_id = $this.data("id");
      var uploadbank_status = $this.data("status");
      if (uploadbank_id <= 0) {
          alert("data error");
          return false;
      }
      if (uploadbank_status == '1') {
        status_txt = '已处理';
      } else if (uploadbank_status == '0') {
        status_txt = '未处理';
      } else {
        status_txt = '准备';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要设置成' + status_txt + '吗?');
      $("#uploadbank_id").val(uploadbank_id);
      $("#uploadbank_status").val(uploadbank_status);
      $("#myModalForm").attr('action', '{{ url('/admin/uploadbank/') }}/' + uploadbank_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var uploadbank_id = $this.data("id");
      if (uploadbank_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#uploadbank_id").val(uploadbank_id);
      $("#myModalForm").attr('action', '/admin/uploadbank/'+ message_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop