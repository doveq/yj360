@extends('Admin.master_column')
@section('title')浏览日志@stop

@section('nav')
  @include('Admin.log.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.log.index', '日志管理')}}</li>
      <li class="active">浏览日志</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '用户', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '用户')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>用户</th>
            <th>URL</th>
            <th>方法</th>
            <th>状态</th>
            <th>访问时间</th>
            <th>浏览器信息</th>
            <!-- <th>操作</th> -->
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->user->name}}</td>
            <td>{{str_replace('http://'.Request::header('host'),'', $list->url)}}</td>
            <td>{{$list->method}}</td>
            <td>{{$list->code}}</td>
            <td>{{$list->created_at}}</td>
            <td>{{str_limit($list->user_agent, 50, '...')}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$lists->appends($query)->links()}}
  </div>

@stop

@section('js')
<script type="text/javascript">

$(function(){

});
</script>
@stop