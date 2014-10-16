@extends('Admin.master_column')
@section('title')科目管理@stop

@section('nav')
  @include('Admin.sort.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.sort.index', '题目分类管理')}}</li>
      <li class="active">编辑分类</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all(), array('class' => 'bg-warning')) }}
      {{ Form::open(array('url' => '/admin/sort/' . $sort->id, 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
        <div class="form-group">
          {{ Form::label('sort_name', '分类名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', $sort->name, array('class' => 'form-control', 'id' => 'sort_name')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('oldpic', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            @if ($sort->thumbnail)
            <img src="{{Config::get('app.thumbnail_url')}}/{{$sort->thumbnail}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
            @else
            无
            @endif
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('sort_thumbnail', '重新选择', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('thumbnail', '', array('id' => 'sort_thumbnail')) }}
            <p class="help-block">如果重新选择图片,会覆盖以前的</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('sort_desc', '分类描述', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('desc', $sort->desc, array('class' => 'form-control', 'id' => 'sort_desc', 'rows' => 3)) }}
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


