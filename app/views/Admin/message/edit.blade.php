@extends('Admin.master_column')
@section('title')班级管理@stop

@section('nav')
  @include('Admin.classes.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.classes.index', '班级管理')}}</li>
      <li class="active">编辑班级</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/classes/' . $class['id'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <div class="form-group">
        {{ Form::label('class_id', '班级ID', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('id', $class['id'], array('class' => 'form-control', 'id' => 'class_id', 'readonly' =>'true')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('class_name', '班级名称', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', $class['name'], array('class' => 'form-control', 'id' => 'class_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('teacher', '教师', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('teacherid', $teachers, $class['teacherid'], array('class' => 'form-control', 'id' => 'teacher')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('class_status', '状态', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('status', $statusEnum, $class['status'], array('class' => 'form-control', 'id' => 'class_status')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('class_memo', '备注', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::textarea('memo', $class['memo'], array('class' => 'form-control', 'id' => 'class_memo', 'rows' => 3)) }}
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
          {{ Form::hidden('_method', 'PUT') }}
          {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
         </div>
      </div>
    {{ Form::close() }}
  </div>
@stop


