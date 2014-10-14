@extends('Admin.master_column')
@section('title')科目内容@stop

@section('nav')
  @include('Admin.subject_content.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
        <li>{{link_to_route('admin.item_content.index', $subject['name'], array('subject_id' => $subject['id']))}}</li>
        <li>{{link_to_route('admin.subject_content.index', $subject_item['name'], array('subject_id' => $subject['id'],'subject_item_id' => $subject_item['id']))}}</li>
        <li class="active">浏览内容</li>
{{link_to_route('admin.subject_content.create', '添加内容', array('subject_id' => $subject['id'],'subject_item_id' => $subject_item['id']),array('class' => 'btn btn-primary btn-xs pull-right'))}}
      </ol>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/subject_content/' . $subject_content['id'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
      <div class="form-group">
        {{ Form::label('content_name', '名称', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('name', $subject_content['name'], array('class' => 'form-control', 'id' => 'content_name')) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('oldpic', '图片', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          <img src="{{Config::get('app.subject_pic_url')}}/{{$subject_content['pic']}}" width="{{Config::get('app.subject_thumb_width')}}" height="{{Config::get('app.subject_thumb_width')}}" class="thumbnail"/>
        </div>
      </div>
      <div class="form-group">
          {{ Form::label('content_pic', '重新选择', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::file('pic', '', array('id' => 'content_pic')) }}
            <p class="help-block">如果重新选择图片,会覆盖以前的</p>
          </div>
        </div>
      <div class="form-group">
        {{ Form::label('subject_content_desc', '描述', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::textarea('desc', $subject_content['description'], array('class' => 'form-control', 'id' => 'subject_content_desc', 'rows' => 3)) }}
        </div>
      </div>
      <div class="form-group">
        {{ Form::label('subject_content_status', '状态', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('status', $statusEnum, $subject_content['status'], array('class' => 'form-control', 'id' => 'subject_content_status')) }}
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


