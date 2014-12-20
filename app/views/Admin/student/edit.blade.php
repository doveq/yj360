@extends('Admin.master_column')
@section('title')学生信息管理@stop

@section('nav')
  @include('Admin.student.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/student">学生信息</a></li>
      <li class="active">编辑信息</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/student/doEdit', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <input name="id" value="{{$info['id']}}" type="hidden" />


      <div class="form-group">
        {{ Form::label('user_status', '状态', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('status', $statusEnum, $info['status'], array('class' => 'form-control', 'id' => 'user_status')) }}
        </div>
      </div>
      
      <div class="form-group">
        {{ Form::label('user_name', '姓名', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', $info['name'], array('class' => 'form-control', 'id' => 'user_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('user_tel', '手机号', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('tel', $info['tel'], array('class' => 'form-control', 'id' => 'user_tel')) }}
        </div>
      </div>
      
      <div class="form-group">
        {{ Form::label('user_address', '地址', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('address', $info['address'], array('class' => 'form-control', 'id' => 'user_address')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_school', '学校', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('school', $info['school'], array('class' => 'form-control', 'id' => 'user_school')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_class', '班级', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('class', $info['class'], array('class' => 'form-control', 'id' => 'user_class')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_teacher', '推荐教师', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('teacher', $info['teacher'], array('class' => 'form-control', 'id' => 'user_teacher')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_retel', '教师手机号', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('retel', $info['retel'], array('class' => 'form-control', 'id' => 'user_retel')) }}
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


