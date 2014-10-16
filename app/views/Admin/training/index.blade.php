@extends('Admin.master_column')
@section('title')训练集管理@stop

@section('nav')
  @include('Admin.training.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.training.index', '训练集管理')}}</li>
      <li class="active">浏览训练集</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '训练集名称', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '训练集名称')) }}
      </div>
      <div class="form-group">
        {{ Form::label('teacherName', '教师名称', array('class' => 'sr-only')) }}
        {{ Form::text('teacher_name', $query['teacher_name'], array('class' => 'form-control', 'id' => 'teacherName', 'placeholder' => '教师名称')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputStatus', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputStatus')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-primary', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>

  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>训练集名称</th>
            <th>老师</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->name}}</td>
            <td>{{$list->teacher->name}}</td>
            <td>
              @if ($list->status == 1)
              <span class="label label-success">{{$statusEnum[$list->status]}}</span>
              @elseif ($list->status == 0)
              <span class="label label-warning">{{$statusEnum[$list->status]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$list->status]}}</span>
              @endif
            </td>
            <td>{{$list->created_at}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/training/'. $list->id .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      @if($list->status === 1)
                      <li><a style='color:#999;'><i class="icon-ok"></i> 上线</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="0"><i class="icon-remove"></i> 准备</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-remove"></i> 下线</a></li>
                      @elseif($list->status === 0)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 上线</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 准备</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-remove"></i> 下线</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 上线</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="0"><i class="icon-remove"></i> 准备</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 下线</a></li>
                      @endif
                  </ul>
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
    {{ Form::hidden('id', '', array('id' => 'training_id')) }}
    {{ Form::hidden('status', '', array('id' => 'training_status')) }}
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
      var training_id = $this.data("id");
      var training_val = $this.data("val");
      var training_status = $this.data("status");
      if (training_id <= 0) {
          alert("data error");
          return false;
      }
      if (training_status == '1') {
        status_txt = '上线';
      } else if (training_status == '0') {
        status_txt = '下线';
      } else {
        status_txt = '准备';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要把'+training_val+'的状态设置成' + status_txt + '吗?');
      $("#training_id").val(training_id);
      $("#training_status").val(training_status);
      $("#myModalForm").attr('action', '{{ url('/admin/training/') }}/' + training_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var training_id = $this.data("id");
      var training_val = $this.data("val");
      if (training_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+training_val+' 吗?');
      $("#training_id").val(training_id);
      $("#myModalForm").attr('action', '/admin/training/'+ training_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop