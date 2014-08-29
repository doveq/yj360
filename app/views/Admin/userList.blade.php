@extends('Admin.master')
@section('title')用户管理@stop


@section('content')
    <div class="container theme-showcase" role="main">
      	<div class="row">
      		<table class="table table-hover">
		      <thead>
		        <tr>
		          <th>#</th>
		          <th>用户名</th>
		          <th>手机号</th>
		          <th>类型</th>
		          <th>状态</th>
		          <th></th>
		        </tr>
		      </thead>
		      <tbody>
		      	@foreach ($list as $user)
		        <tr>
		          <td>{{$user->id}}</td>
		          <td>{{$user->name}}</td>
		          <td>{{$user->tel}}</td>
		          <td>{{$typeEnum[$user->type]}}</td>
		          <td>{{$statusEnum[$user->status]}}</td>
		          <td><a href="" class="btn btn-primary btn-xs">管理</a></td>
		        </tr>
		       	@endforeach
		      </tbody>
		    </table>
      	</div>
   	</div>
@stop