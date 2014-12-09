@extends('Admin.master_column')
@section('title')帮助反馈@stop

@section('nav')
  @include('Admin.notice.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/notice">帮助反馈</a></li>
      <li class="active">添加</li>
    </ol>
  </div>

  <div class="row">
  <form class="form-horizontal" enctype="multipart/form-data" role="form" accept-charset="UTF-8" action="/admin/notice/doAdd" method="POST">
      
      <div class="form-group">
          <label class="col-md-1 control-label" for="column_name">类型</label>
          <div class="col-md-10">
            {{ Form::select('type', $typeEnum, '', array('class' => 'form-control', 'id' => 'column_parent')) }}
          </div>
      </div>

      <div class="form-group">
          <label class="col-md-1 control-label" for="column_name">标题</label>
          <div class="col-md-10">
            <input type="text" value="" name="title" id="column_name" class="form-control">
          </div>
      </div>

      <div class="form-group">
          <label class="col-md-1 control-label" for="column_name">内容</label>
          <div class="col-md-10">
            <textarea rows="5" id="content" name="content"></textarea>
          </div>
      </div>

      <div class="form-group">
          <label for="inputPassword" class="col-sm-3 control-label"></label>
          <div class="col-sm-9">
              <button type="submit" class="btn btn-success">提交保存</button>
          </div>
        </div>
      </form>
  </form>
  </div>
 
@stop

@section('js')
    <script type="text/javascript" src="/assets/ueditor/ueditor-notice.config.js"></script>
    <script type="text/javascript" src="/assets/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>

    <script type="text/javascript">
        var ue = UE.getEditor('content');
    </script>

@stop