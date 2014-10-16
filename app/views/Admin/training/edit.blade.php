@extends('Admin.master_column')
@section('title')班级管理@stop

@section('nav')
  @include('Admin.training.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.training.index', '班级管理')}}</li>
      <li class="active">编辑班级</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/training/' . $training['id'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <div class="form-group">
        {{ Form::label('training_id', 'ID', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('id', $training['id'], array('class' => 'form-control', 'id' => 'training_id', 'readonly' =>'true')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('training_name', '训练集名称', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', $training['name'], array('class' => 'form-control', 'id' => 'training_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('teacher', '教师', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('user_id', $teachers, $training['teacherid'], array('class' => 'form-control', 'id' => 'teacher')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('training_status', '状态', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('status', $statusEnum, $training['status'], array('class' => 'form-control', 'id' => 'training_status')) }}
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


