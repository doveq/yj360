@extends('Admin.master_column')
@section('title')日志管理@stop

@section('nav')
  @include('Admin.log.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.log.index', '登陆日志')}}</li>
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
            <th>登陆时间</th>
            <th>ip</th>
            <th>省市</th>
            <th>浏览器信息</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->user->name}}</td>
            <td>{{$list->created_at}}</td>
            <td>{{$list->ip}}</td>
            <td>
              @if ($list->city)
              {{$list->city}}
              @endif
            </td>
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