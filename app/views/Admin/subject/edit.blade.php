@extends('Admin.master_column')
@section('title')编辑科目@stop

@section('nav')
  @include('Admin.subject.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">科目管理</a></li>
      <li class="active">编辑科目</li>
    </ol>
  </div>
  <div class="row">
      @include('admin.notifications')
      <form class="form-horizontal" role="form" action="/admin/subject/{{$subject['id']}}" method="post">
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
          <label for="subject_status" class="col-md-2 control-label">科目状态</label>
          <div class="col-md-6">
            <select class="form-control" name="status" id="subject_status">
              <option value="" >所有状态</option>
              @foreach ($statusEnum as $v => $n)
                  <option value="{{$v}}" @if( is_numeric($subject['status']) && $v == $subject['status']) selected="selected" @endif >{{$n}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="subject_online_at" class="col-md-2 control-label">上线时间</label>
          <div class="col-md-6">
            <input class="form-control" id="subject_online_at" name="online_at" value="{{$subject['online_at']}}">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <input name="_method" type="hidden" value="PUT">
            <button type="submit" class="btn btn-default">提交</button>
          </div>
        </div>
      </form>
  </div>
@stop