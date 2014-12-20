@extends('Admin.master_column')
@section('title')学生信息管理@stop

@section('nav')
  @include('Admin.student.nav')
@stop

@section('css')
  <link href="/assets/lightbox/css/lightbox.css" rel="stylesheet" />
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.user.index', '用户管理')}}</li>
      <li class="active">浏览用户</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '姓名', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '姓名')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '手机号', array('class' => 'sr-only')) }}
        {{ Form::text('tel', $query['tel'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '手机号')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '推荐老师', array('class' => 'sr-only')) }}
        {{ Form::text('teacher', $query['teacher'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '推荐老师')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '老师手机', array('class' => 'sr-only')) }}
        {{ Form::text('retel', $query['retel'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '老师手机')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputType', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputType')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th width="80">姓名</th>
            <th width="100">手机号</th>
            <th>地址</th>
            <th>学校</th>
            <th>班级</th>
            <th>推荐老师</th>
            <th>老师手机</th>
            <th width="50">状态</th>
            <th width="120">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->name}}</td>
            <td>{{$list->tel}}</td>
            <td>{{$list->address}}</td>
            <td>{{$list->school}}</td>
            <td>{{$list->class}}</td>
            <td>{{$list->teacher}}</td>
            <td>{{$list->retel}}</td>
            <td>{{$statusEnum[$list->status]}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/student/edit?id='. $list->id) }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>
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
    {{ Form::hidden('id', '', array('id' => 'user_id')) }}

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
<script src="/assets/lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">

$(function(){

  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var user_id = $this.data("id");
      var user_val = $this.data("val");
      if (user_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+user_val+' 吗?');
      $("#user_id").val(user_id);
      $("#myModalForm").attr('action', '/admin/student/doDel?id='+ user_id);
      $('#myModal').modal('show');
  });
});
</script>
@stop