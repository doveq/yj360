@extends('Admin.master_column')
@section('title')产品管理 @stop

@section('nav')
  @include('Admin.product.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.product.index', '产品管理')}}</li>
      <li class="active">编辑产品</li>
    </ol>
  </div>

  <div class="row">
      {{ HTML::ul($errors->all(), array('class' => 'bg-warning')) }}
      {{ Form::open(array('url' => '/admin/product/' . $product->id, 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
        <div class="form-group">
          {{ Form::label('inputName', '名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', $product->name, array('class' => 'form-control', 'id' => 'inputName')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('oldpic', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            @if ($product->thumbnail)
            <img src="{{Config::get('app.thumbnail_url')}}/{{$product->thumbnail}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
            @else
            无
            @endif
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPic', '重新选择', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('thumbnail', '', array('id' => 'inputPic')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPrice', '价格', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('price', $product->price, array('class' => 'form-control', 'id' => 'inputPrice')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPeriod', '有效期', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('period', $product->valid_period, array('class' => 'form-control', 'id' => 'inputPeriod')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPolicy', '策略', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('policy', $policyEnum, $product->policy, array('class' => 'form-control', 'id' => 'inputPolicy')) }}
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