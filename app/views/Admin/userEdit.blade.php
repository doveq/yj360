@extends('Admin.master')
@section('title')用户管理@stop


@section('content')
    <div class="container theme-showcase" role="main">
      	<div class="row">

      		<form class="form-horizontal" role="form" action="/admin/doUserEdit" method="post">
      		  <input type="hidden" name="id" value="{{$user['id']}}" />

			  <div class="form-group">
			    <label class="col-sm-3 control-label">ID</label>
			    <div class="col-sm-9">
			      <p class="form-control-static">{{$user['id']}}</p>
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="col-sm-3 control-label">用户名</label>
			    <div class="col-sm-9">
			      <p class="form-control-static">{{$user['name']}}</p>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-3 control-label">手机号</label>
			    <div class="col-sm-9">
			      <p class="form-control-static">{{$user['tel']}}</p>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-3 control-label">类型</label>
			    <div class="col-sm-9">
			      	<select class="form-control" name="type">
			      		@foreach ($typeEnum as $v => $n)
					  		<option value="{{$v}}" @if($v == $user['type']) selected="selected" @endif >{{$n}}</option>
					  	@endforeach
					</select>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-3 control-label">状态</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="status">
			      		@foreach ($statusEnum as $v => $n)
					  		<option value="{{$v}}" @if($v == $user['status']) selected="selected" @endif >{{$n}}</option>
					  	@endforeach
					</select>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-3 control-label">注册时间</label>
			    <div class="col-sm-9">
			      <p class="form-control-static">{{$user['created_at']}}</p>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-3 control-label">最后登录时间</label>
			    <div class="col-sm-9">
			      <p class="form-control-static">{{$user['updated_at']}}</p>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-3 control-label"></label>
			    <div class="col-sm-9">
			      	<button type="button" class="btn btn-danger">删除用户</button>
			      	<button type="submit" class="btn btn-success">保存编辑</button>
			    </div>
			  </div>
			</form>

      	</div>
   	</div>
@stop