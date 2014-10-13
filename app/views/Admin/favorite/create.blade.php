@extends('Admin.master_column')
@section('title')站点消息@stop

@section('nav')
  @include('Admin.message.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.message.index', '站点消息')}}</li>
      <li class="active">发送消息</li>
    </ol>
  </div>
  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/message/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
          {{ Form::label('receiver_name', '收件人', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', '', array('class' => 'form-control', 'id' => 'receiver_name')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('message_content', '内容', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::textarea('content', '', array('class' => 'form-control', 'id' => 'message_content', 'rows' => 3)) }}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            {{ Form::hidden('type', 1) }}
            {{ Form::submit('发送', array('class' => 'btn btn-default')) }}
           </div>
        </div>
      {{ Form::close() }}
  </div>
@stop