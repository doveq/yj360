@extends('Admin.master_column')
@section('title')班级管理@stop

@section('nav')
  @include('Admin.classmate.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.classes.index', '班级管理')}}</li>
      <li>{{link_to_route('admin.classmate.index', $classes->name, array('class_id' => $classes->id))}} <span class="badge">{{$teacher->name}}</span></li>
      <li class="active">学生列表 <span class="badge">{{$lists->count()}}</span></li>
    </ol>
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>姓名</th>
            <th>性别</th>
            <th>电话</th>
            <th>状态</th>
            <th>加入时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->name}}</td>
            <td>{{$genderEnum[$list->gender]}}</td>
            <td>{{$list->tel}}</td>
            <td>
              @if ($list->pivot->status == 1)
              <span class="label label-success">{{$statusEnum[$list->pivot->status]}}</span>
              @elseif ($list->pivot->status == 0)
              <span class="label label-warning">{{$statusEnum[$list->pivot->status]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$list->pivot->status]}}</span>
              @endif
            </td>
            <td>{{$list->pivot->created_at}}</td>
            <td>
              <div class="btn-group btn-xs">
                @if ($list->pivot->status === 1)
                  <a class="btn btn-default btn-xs btn_publish disabled"><i class="glyphicon glyphicon-ok"></i></a>
                @else
                  <a class="btn btn-default btn-xs btn_publish" href="#" data-toggle="modal" data-id="{{$list->pivot->id}}" data-val="{{$list['name']}}" data-status="1"><i class="glyphicon glyphicon-ok"></i></a>
                @endif
                  <a class="btn btn-default btn-xs btn_delete" href="#" data-toggle="modal" data-id="{{$list->pivot->id}}" data-val="{{$list['name']}}" data-status="-1"><i class="glyphicon glyphicon-remove"></i></a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'classmate_id')) }}
    {{ Form::hidden('status', '', array('id' => 'classmate_status')) }}
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
      var classmate_id = $this.data("id");
      var classmate_val = $this.data("val");
      var classmate_status = $this.data("status");
      if (classmate_id <= 0) {
          alert("data error");
          return false;
      }
      if (classmate_status == '1') {
        status_txt = '审核通过';
      } else if (classmate_status == '0') {
        status_txt = '申请';
      } else {
        status_txt = '删除';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要把'+classmate_val+'的状态设置成' + status_txt + '吗?');
      $("#classmate_id").val(classmate_id);
      $("#classmate_status").val(classmate_status);
      $("#myModalForm").attr('action', '{{ url('/admin/classmate/') }}/' + classmate_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var classmate_id = $this.data("id");
      var classmate_val = $this.data("val");
      if (classmate_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+classmate_val+' 吗?');
      $("#classmate_id").val(classmate_id);
      $("#myModalForm").attr('action', '/admin/classmate/'+ classmate_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop