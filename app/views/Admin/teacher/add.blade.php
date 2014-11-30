@extends('Admin.master_column')
@section('title')老师信息管理@stop

@section('nav')
  @include('Admin.teacher.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/teacher">老师信息</a></li>
      <li class="active">添加信息</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/teacher/doAdd', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <div class="form-group">
        {{ Form::label('user_type', '类型', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('type', $typeEnum, '', array('class' => 'form-control', 'id' => 'user_type')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_name', '姓名', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'user_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('user_tel', '手机号', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('tel', '', array('class' => 'form-control', 'id' => 'user_tel')) }}
        </div>
      </div>
      

      <div class="form-group">
        {{ Form::label('user_qq', 'QQ', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('qq', '', array('class' => 'form-control', 'id' => 'user_qq')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_professional', '学校及专业', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('professional', '', array('class' => 'form-control', 'id' => 'user_professional')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_address', '地址', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('address', '', array('class' => 'form-control', 'id' => 'user_address')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_school', '当前学校', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('school', '', array('class' => 'form-control', 'id' => 'user_school')) }}
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


