@extends('Admin.master_column')
@section('title')科目管理@stop

@section('nav')
  @include('Admin.sort.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.sort.index', '题目分类管理')}}</li>
      @if ($query['parent_id'] > 0)
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      @endif
      <li class="active">添加分类</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all(), array('class' => 'bg-warning')) }}
      {{ Form::open(array('url' => '/admin/sort/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
        <div class="form-group">
          {{ Form::label('sort_name', '分类名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'sort_name')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('sort_thumbnail', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('thumbnail', '', array('id' => 'sort_thumbnail')) }}
            <p class="help-block">如果有展示图片,请选择.</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('sort_desc', '分类描述', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('desc', '', array('class' => 'form-control', 'id' => 'sort_desc', 'rows' => 3)) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('sort_parent', '父级分类', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('parent_id', $sort, $query['parent_id']?$query['parent_id']:0, array('class' => 'form-control', 'id' => 'sort_parent')) }}
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