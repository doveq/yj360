@extends('Admin.master_column')
@section('title')添加内容@stop

@section('nav')
  @include('Admin.product.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.product.index', '产品管理')}}</li>
      <li class="active">添加产品</li>
    </ol>
  </div>

  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/product/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
          {{ Form::label('content_name', '名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'content_name')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('pic', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('pic', '', array('id' => 'pic')) }}
            <p class="help-block">请选择展示图片</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('description', '描述', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('description', '', array('class' => 'form-control', 'id' => 'description', 'rows' => 3)) }}
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