@extends('Admin.master_column')
@section('title')添加科目@stop

@section('nav')
  @include('Admin.subject.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
      <li class="active">添加科目</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/subject/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <div class="form-group">
        {{ Form::label('subject_name', '科目名称', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'subject_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('subject_desc', '科目描述', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::textarea('desc', '', array('class' => 'form-control', 'id' => 'subject_desc', 'rows' => 3)) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('online_at', '上线时间', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('online_at', '', array('class' => 'form-control form_datetime', 'readonly' => 1)) }}
        </div>

      </div>

      <div class="form-group">
        {{ Form::label('subject_status', '状态', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('status', $statusEnum, 0, array('class' => 'form-control', 'id' => 'subject_status')) }}
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
          {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
         </div>
      </div>
    {{ Form::close() }}
  </div>
@stop

@section('js')
<script type="text/javascript">
$(function(){
  $('.form_datetime').datetimepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayBtn: true,
    minView: "month",
    maxView: "month",
    language: 'zh-CN',
    viewSelect: "month"
  });
});


</script>
@stop