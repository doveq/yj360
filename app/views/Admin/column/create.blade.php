@extends('Admin.master_column')
@section('title')科目管理@stop

@section('nav')
  @include('Admin.column.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
      <li class="active">添加科目</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/column/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
        <div class="form-group">
          {{ Form::label('column_name', '科目名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'column_name')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('column_thumbnail', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('thumbnail', '', array('id' => 'column_thumbnail')) }}
            <p class="help-block">请选择展示图片</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('column_desc', '科目描述', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('desc', '', array('class' => 'form-control', 'id' => 'column_desc', 'rows' => 3)) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('column_parent', '父级科目', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('parent_id', $column, $query['parent_id']?$query['parent_id']:0, array('class' => 'form-control', 'id' => 'column_parent')) }}
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