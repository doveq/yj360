@extends('Admin.master_column')
@section('title')试卷管理@stop


@section('content')

  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/examPaper">试卷管理</a></li>
        <li><a href="/admin/examPaper/clist?id={{$parent->id}}">{{$parent->title}}</a></li>
    </ol>
  </div>

  <div class="row">

        @if(!empty($info))
        <form method="POST" action="/admin/examPaper/doEdit" role="form" class="form-horizontal">
        <input type="hidden" name="id" value="{{$info->id}}" />
        <input type="hidden" name="from" value="/admin/examPaper/clist?id={{$parent->id}}" />
        @else
        <form method="POST" action="/admin/examPaper/doAdd" role="form" class="form-horizontal">
        <input type="hidden" name="parent_id" value="{{$parent->id}}" />
        <input type="hidden" name="from" value="/admin/examPaper/clist?id={{$parent->id}}" />
        @endif

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">大题题干</label>
          <div class="col-md-6">
            <input class="form-control" id="title" name="title" type="text" value="{{$info->title or ''}}">
          </div>
        </div>
        
        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">出题数</label>
          <div class="col-md-6">
            <input class="form-control" id="rnum" name="rnum" type="text" value="{{$info->rnum or '0'}}">
          </div>
        </div>

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">每题分数</label>
          <div class="col-md-6">
            <input class="form-control" id="score" name="score" type="text" value="{{$info->score or '1'}}">
          </div>
        </div>

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">排序序号</label>
          <div class="col-md-6">
            <input class="form-control" id="ordern" name="ordern" type="text" value="{{$info->ordern or '0'}}">
            <p class="help-block">序号越小,排序越靠前</p>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <input type="submit" value="提交" class="btn btn-default">
           </div>
        </div>

      </form>
  </div>
@stop
