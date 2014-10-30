@extends('Admin.master_column')
@section('title')科目管理@stop


@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li class="active">添加试卷</li>
    </ol>
  </div>
  <div class="row">
      <form method="POST" action="/admin/examPaper/doAdd" role="form" class="form-horizontal">
        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">试卷名</label>
          <div class="col-md-6">
            <input class="form-control" id="title" name="title" type="text" value="">
          </div>
        </div>

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">试卷名</label>
          <div class="col-md-6">
            <input class="form-control" id="title" name="title" type="text" value="">
          </div>
        </div>
        
      </form>
  </div>
@stop
