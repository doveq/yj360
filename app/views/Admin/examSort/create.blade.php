@extends('Admin.master_column')
@section('title')试卷分类管理@stop

@section('nav')
  @include('Admin.examSort.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.examSort.index', '试卷分类管理')}}</li>
      @if ($query['parent_id'] > 0)
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.examSort.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      @endif
      <li class="active">添加科目</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all(), array('class' => 'bg-warning')) }}
      {{ Form::open(array('url' => '/admin/examSort/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
        <div class="form-group">
          {{ Form::label('column_name', '分类名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'column_name')) }}
          </div>
        </div>
        <!--
        <div class="form-group">
          {{ Form::label('column_thumbnail', '图片', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('thumbnail', '', array('id' => 'column_thumbnail')) }}
            <p class="help-block">如果有展示图片,请选择.</p>
          </div>
        </div>
        -->
        <div class="form-group">
          {{ Form::label('column_desc', '分类描述', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('desc', '', array('class' => 'form-control', 'id' => 'column_desc', 'rows' => 3)) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('column_parent', '父级分类', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('parent_id', $column, $query['parent_id']?$query['parent_id']:0, array('class' => 'form-control', 'id' => 'column_parent')) }}
          </div>
        </div>
        <!--
        <div class="form-group">
          {{ Form::label('column_type', '素材类型', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('type', $typeEnum, 0, array('class' => 'form-control', 'id' => 'column_type')) }}
          </div>
        </div>
        -->
        <div class="form-group">
          {{ Form::label('column_ordern', '排序序号', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('ordern', '', array('class' => 'form-control', 'id' => 'column_ordern')) }}
            <p class="help-block">序号越小,排序越靠前,默认等于科目id</p>
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
