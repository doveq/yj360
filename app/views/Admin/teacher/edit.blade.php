@extends('Admin.master_column')
@section('title')老师信息管理@stop

@section('nav')
  @include('Admin.teacher.nav')
@stop

@section('headjs')
<script src="/assets/js/PCASClass.js"></script>
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/teacher">老师信息</a></li>
      <li class="active">编辑信息</li>
    </ol>
  </div>
  <div class="row">
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => '/admin/teacher/doEdit', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
      <input name="id" value="{{$info['id']}}" type="hidden" />

      <div class="form-group">
        {{ Form::label('user_type', '类型', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::select('type', $typeEnum, $info['type'], array('class' => 'form-control', 'id' => 'user_type')) }}
        </div>
      </div>

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
        {{ Form::label('user_qq', 'QQ', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('qq', $info['qq'], array('class' => 'form-control', 'id' => 'user_qq')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_professional', '学校及专业', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('professional', $info['professional'], array('class' => 'form-control', 'id' => 'user_professional')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_school', '当前学校', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('school', $info['school'], array('class' => 'form-control', 'id' => 'user_school')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_district', '地区', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6 form-inline">
          <select name="province" class="form-control"></select>
          <select name="city" class="form-control"></select>
          <select name="district" class="form-control"></select>
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('user_address', '详细地址', array('class' => 'col-md-2 control-label')) }}
        <div class="col-md-6">
          {{ Form::text('address', $info['address'], array('class' => 'form-control', 'id' => 'user_address')) }}
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

@section('js')
<script type="text/javascript">
  new PCAS("province={{$info['province']}},选择省份","city={{$info['city']}},选择城市","district={{$info['district']}},选择地区");
</script>
@stop

