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
      <li class="active">邀请学生</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('url' => '/admin/classmate/create','role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '用户名', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '用户名')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '手机号', array('class' => 'sr-only')) }}
        {{ Form::text('tel', $query['tel'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '手机号')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputStatus', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputStatus')) }}
      </div>
      {{ Form::hidden('class_id', $classes->id) }}
      {{ Form::button('查找', array('class' => 'btn btn-primary', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>
  <div class="row">
    {{ Form::open(array('url' => '/admin/classmate/','role' => 'form', 'class' => 'form-horizontal', 'method' => 'post')) }}
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">学生列表</h3>
      </div>
      <div class="panel-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">ID</th>
              <th class="text-center">名称</th>
              <th class="text-center">电话</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $list)
            <tr class="text-center">
              <td>
                @if ($list->checked === 1)
                {{ Form::checkbox('student_id[]', $list->id, true, array('id' => 'userid'.$list->id)) }}
                @else
                {{ Form::checkbox('student_id[]', $list->id, false, array('id' => 'userid'.$list->id)) }}
                @endif
              </td>
              <td>
                {{ Form::label('userid'.$list->id, $list->id) }}
              </td>
              <td>
                {{ Form::label('userid'.$list->id, $list->name) }}
              </td>
              <td>{{$list->tel}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="col-md-12">
          <div class="col-md-6 text-right">
            {{ Form::hidden('class_id', $classes->id, array('id' => 'class_id')) }}
            {{ Form::button('邀请', array('class' => 'btn btn-primary', 'type' =>'submit')) }}
            {{ Form::checkbox('check_all', 1, false, array('id' => 'check_all')) }}
            {{ Form::label('check_all', '全选') }}
          </div>
          <div class="col-md-6 text-right">
            {{$students->appends(Input::all())->links()}}
          </div>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>


@stop

@section('js')
<script type="text/javascript">

$(function(){
  $("#check_all").click(function() {
      $('input[name="student_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='student_id[]']");
  $subBox.click(function(){
      $("#check_all").prop("checked",$subBox.length == $("input[name='student_id[]']:checked").length ? true : false);
  });
});
</script>
@stop