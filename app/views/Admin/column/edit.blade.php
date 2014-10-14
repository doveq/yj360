@extends('Admin.master_column')
@section('title')科目管理@stop

@section('nav')
  @include('Admin.column.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
      <li class="active">编辑科目</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/column/' . $column->id, 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
          {{ Form::label('column_name', '名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', $column->name, array('class' => 'form-control', 'id' => 'column_name')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('column_desc', '描述', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('desc', $column->desc, array('class' => 'form-control', 'id' => 'column_desc', 'rows' => 3)) }}
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


