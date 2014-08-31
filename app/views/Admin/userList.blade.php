@extends('Admin.master')
@section('title')用户管理@stop


@section('content')
    <div class="container theme-showcase" role="main" action="/admin/userList" method="get">
    	<div class="row text-right">
    		<form class="form-inline" role="form">
			  <div class="form-group">
			    <label class="sr-only" for="inputName">用户名</label>
			    <input type="text" name="name" value="{{$query['name']}}" class="form-control" id="inputName" placeholder="用户名">
			  </div>

			  <div class="form-group">
			    <label class="sr-only" for="inputTel">手机号</label>
			    <input type="text" name="tel" value="{{$query['tel']}}" class="form-control" id="inputTel" placeholder="手机号">
			  </div>

			  <div class="form-group">
			    <label class="sr-only" for="inputType">类型</label>
			    <select class="form-control" name="type" id="inputType">
			    	<option value="" >所有类型</option>
		      		@foreach ($typeEnum as $v => $n)
				  		<option value="{{$v}}" @if( is_numeric($query['type']) && $v == $query['type']) selected="selected" @endif >{{$n}}</option>
				  	@endforeach
				</select>
			  </div>

			  <div class="form-group">
			    <label class="sr-only" for="inputStatus">状态</label>
			    <select class="form-control" name="status" id="inputStatus">
			    	<option value="" >所有状态</option>
		      		@foreach ($statusEnum as $v => $n)
				  		<option value="{{$v}}" @if( is_numeric($query['status']) && $v == $query['status']) selected="selected" @endif >{{$n}}</option>
				  	@endforeach
				</select>
			  </div>

			  <button type="submit" class="btn btn-success">查找</button>
			</form>
    	</div>

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
		          <td>{{$user['id']}}</td>
		          <td>{{$user['name']}}</td>
		          <td>{{$user['tel']}}</td>
		          <td>{{$typeEnum[$user['type']]}}</td>
		          <td>{{$statusEnum[$user['status']]}}</td>
		          <td><a href="/admin/userEdit/{{$user['id']}}" class="btn btn-primary btn-xs">管理</a></td>
		        </tr>
		       	@endforeach
		      </tbody>
		    </table>

      	</div>

      	<div class="row text-right">
      		{{$paginator->links()}}
      	</div>
   	</div>
@stop