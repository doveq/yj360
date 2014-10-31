@extends('Admin.master_column')
@section('title')试卷管理@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      <li class="active">添加试卷</li>
    </ol>
  </div>

  <div class="row">
      <div class="col-md-4 col-md-offset-8 text-right">
          <a href="/admin/examPaper/add?column_id={{$columnId}}" class="btn btn-success">添加试卷</a>
      </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>名称</th>
            <th>描述</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'column_id')) }}
    {{ Form::hidden('status', '', array('id' => 'column_status')) }}
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
      var column_id = $this.data("id");
      var column_status = $this.data("status");
      if (column_id <= 0) {
          alert("data error");
          return false;
      }
      if (column_status == '1') {
        status_txt = '发布';
      } else if (column_status == '-1') {
        status_txt = '下线';
      } else {
        status_txt = '准备';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要设置成' + status_txt + '吗?');
      $("#column_id").val(column_id);
      $("#column_status").val(column_status);
      $("#myModalForm").attr('action', '{{ url('/admin/column/') }}/' + column_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var column_id = $this.data("id");
      if (column_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#column_id").val(column_id);
      $("#myModalForm").attr('action', '/admin/column/'+ column_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop
