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
      {{ Form::open(array('url' => '/admin/product/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal','files' => true)) }}
        <div class="form-group">
          {{ Form::label('inputName', '名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'inputName')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPic', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('thumbnail', '', array('id' => 'inputPic')) }}
            <p class="help-block">请选择展示图片</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPrice', '价格', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('price', '', array('class' => 'form-control', 'id' => 'inputPrice')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPeriod', '有效期', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('period', '', array('class' => 'form-control', 'id' => 'inputPeriod')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPolicy', '策略', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('policy', $policyEnum, array('class' => 'form-control', 'id' => 'inputPolicy')) }}
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