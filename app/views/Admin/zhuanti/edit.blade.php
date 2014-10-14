@extends('Admin.master_column')
@section('title')专题管理@stop

@section('nav')
  @include('Admin.zhuanti.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.zhuanti.index', '专题管理')}}</li>
      <li class="active">编辑专题</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/zhuanti/' . $column->id, 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
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


