@extends('Admin.master_column')
@section('title')添加科目@stop

@section('nav')
  @include('Admin.subject_item.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">科目功能管理</a></li>
      <li class="active">添加科目功能</li>
    </ol>
  </div>
  <div class="row">
    @include('admin.notifications')
      <form class="form-horizontal" role="form" action="/admin/subject_item" method="post">
        <div class="form-group">
          <label for="subject_name" class="col-md-2 control-label">科目项目名称</label>
          <div class="col-md-6">
            <input class="form-control" id="subject_name" name="name" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <button type="submit" class="btn btn-default">提交</button>
          </div>
        </div>
      </form>
  </div>
@stop