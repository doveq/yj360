@extends('Admin.master_column')
@section('title')学生信息管理@stop

@section('nav')
  @include('Admin.student.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/student">学生信息</a></li>
      <li class="active">导入信息</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/student/doImport', 'method' => 'post', 'enctype' => "multipart/form-data", 'role' => 'form', 'class' => 'form-horizontal')) }}

      <div class="form-group">
        <label class="col-md-2 control-label" for="user_teacher">选择上传csv文件</label>
        <div class="col-md-6">
          <input type="file" name="csv" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
          {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
         </div>
      </div>

      @if( !empty($user['route']) )
      <div class="form-group">
        <div class="col-md-6">
          <img src="{{$user['route']['url']}}" />
        </div>
      </div>
      @endif

    {{ Form::close() }}
  </div>
@stop


