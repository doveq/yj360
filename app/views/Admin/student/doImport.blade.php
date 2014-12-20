@extends('Admin.master_column')
@section('title')学生信息管理@stop

@section('nav')
  @include('Admin.student.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/student">学生信息</a></li>
      <li class="active">导入结果</li>
    </ol>
  </div>
  <div class="row">
    
    <blockquote>
      <p>共导入{{$count}}条数据.</p>
    </blockquote>

    <br/>

    @if(!empty($exists))
    <p class="bg-danger">手机号已存在未导入：</p>
    <table class="table table-striped">
      @foreach($exists as $v)
      <tr>
        <td>{{$v['name']}}</td>
        <td>{{$v['tel']}}</td>
        <td>{{$v['address']}}</td>
        <td>{{$v['school']}}</td>
        <td>{{$v['class']}}</td>
        <td>{{$v['teacher']}}</td>
      </tr>
      @endforeach
    </table>
    @endif

    <br/>

    @if(!empty($errors))
    <p class="bg-danger">数据错误未导入：</p>
    <table class="table table-striped">
      @foreach($errors as $v)
      <tr>
        <td>{{$v['name']}}</td>
        <td>{{$v['tel']}}</td>
        <td>{{$v['address']}}</td>
        <td>{{$v['school']}}</td>
        <td>{{$v['class']}}</td>
        <td>{{$v['teacher']}}</td>
      </tr>
      @endforeach
    </table>
    @endif

  </div>
@stop


