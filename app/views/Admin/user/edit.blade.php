@extends('Admin.master_column')
@section('title')编辑用户@stop

@section('nav')
  @include('Admin.user.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.user.index', '用户管理')}}</li>
      <li class="active">编辑用户</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/user/' . $user['id'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <div class="form-group">
        {{ Form::label('user_name', '用户名', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', $user['name'], array('class' => 'form-control', 'id' => 'user_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('user_tel', '手机号', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('tel', $user['tel'], array('class' => 'form-control', 'id' => 'user_tel')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('user_type', '类型', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('type', $typeEnum, $user['type'], array('class' => 'form-control', 'id' => 'user_type')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('user_status', '状态', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('status', $statusEnum, $user['status'], array('class' => 'form-control', 'id' => 'user_status')) }}
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
          {{ Form::hidden('_method', 'PUT') }}
          {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
         </div>
      </div>
    {{ Form::close() }}
  </div>
@stop


