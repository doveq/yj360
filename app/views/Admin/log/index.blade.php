@extends('Admin.master_column')
@section('title')浏览日志@stop

@section('nav')
  @include('Admin.log.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.log.index', '日志管理')}}</li>
      <li class="active">浏览日志</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '用户', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['user_id'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '日志名称')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputDesc', '操作', array('class' => 'sr-only')) }}
        {{ Form::text('desc', $query['content'], array('class' => 'form-control', 'id' => 'inputDesc', 'placeholder' => '日志描述')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputStatus', '类型', array('class' => 'sr-only')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>

  <div class="row text-right">
      {{$paginator->links()}}
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>用户</th>
            <th>操作</th>
            <th>类型</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $log)
          <tr>
            <td>{{$log['id']}}</td>
            <td>{{$log['user_id']}}</td>
            <td>{{$log['content']}}</td>
            <td>{{$log['type']}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/log/'. $log['id'] .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="{{url('/admin/log_item_relation/'. $log['id'] .'/edit') }}"><i class="icon-asterisk"></i> 功能管理</a></li>
                      <li><a href="{{url('/admin/log_content/'. $log['id'] .'/edit') }}"><i class="icon-magic"></i> 内容管理</a></li>
                      <li class="divider"></li>
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$log['id']}}" data-val="{{$log['content']}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>

                  </ul>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$paginator->links()}}
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'log_id')) }}
    {{ Form::hidden('status', '', array('id' => 'log_status')) }}
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
      var log_id = $this.data("id");
      var log_val = $this.data("val");
      var log_status = $this.data("status");
      if (log_id <= 0) {
          alert("data error");
          return false;
      }
      if (log_status == '1') {
        status_txt = '上线';
      } else if (log_status == '-1') {
        status_txt = '下线';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要' + status_txt + ' '+log_val+' 吗?');
      $("#log_id").val(log_id);
      $("#log_status").val(log_status);
      $("#myModalForm").attr('action', '{{ url('/admin/log/') }}/' + log_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var log_id = $this.data("id");
      var log_val = $this.data("val");
      if (log_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+log_val+' 吗?');
      $("#log_id").val(log_id);
      $("#myModalForm").attr('action', '/admin/log/'+ log_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop