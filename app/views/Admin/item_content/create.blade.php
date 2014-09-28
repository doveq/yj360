@extends('Admin.master_column')
@section('title')添加内容@stop

@section('nav')
  @include('Admin.item_content.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.item_content.index', '内容管理')}}</li>
      <li class="active">添加内容</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/item_content/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
          {{ Form::label('subject_item_name', '科目功能名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'subject_item_name')) }}
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