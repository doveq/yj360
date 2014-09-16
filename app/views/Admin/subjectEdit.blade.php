@extends('Admin.master_column')
@section('title')编辑科目@stop

@section('nav')
  @include('Admin.subject_nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">科目管理</a></li>
      <li class="active">编辑科目</li>
    </ol>
  </div>
  <div class="row">
      <form class="form-horizontal" role="form">
        <div class="form-group">
          <label for="subject_name" class="col-md-2 control-label">科目名称</label>
          <div class="col-md-6">
            <input class="form-control" id="subject_name" name="name" value="{{$subject['name']}}">
          </div>
        </div>
        <div class="form-group">
          <label for="subject_desc" class="col-md-2 control-label">科目描述</label>
          <div class="col-md-6">
            <textarea class="form-control" rows="4" id="subject_desc" name="desc">{{$subject['description']}}</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <input type="hidden" id="subject_id" name="id" value="{{$subject['id']}}"/>
            <button type="submit" class="btn btn-default">提交</button>
          </div>
        </div>
      </form>
  </div>
@stop