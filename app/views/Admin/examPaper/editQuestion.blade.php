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
        <form method="POST" action="/admin/examPaper/doEdit" role="form" class="form-horizontal">
        <input type="hidden" name="id" value="{{$info->id}}" />
        <input type="hidden" name="from" value="/admin/examPaper/clist?id={{$parent->id}}" />
        

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">题目</label>
          <div class="col-md-6">
            
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
