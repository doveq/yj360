@extends('Admin.master')
@section('title')添加题目@stop


@section('content')
    <div class="container theme-showcase" role="main">
      	<div class="row">

      		<form class="form-horizontal" role="form" action="/admin/doTopicAdd" method="post" enctype="multipart/form-data">
      		  
      		  <div class="form-group">
			    <label class="col-sm-2 control-label">类型</label>
			    <div class="col-sm-10">
			      <select class="form-control" name="type">
					  		<option value="1" selected="selected">类型</option>
					</select>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">题干</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="file_txt">
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">题干图片</label>
			    <div class="col-sm-10">
			      <input type="file" title="选择上传" name="file_img" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">提示音</label>
			    <div class="col-sm-10">
			      <input type="file" title="选择上传" name="file_hint" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">提干音</label>
			    <div class="col-sm-10">
			      <input type="file" title="选择上传" name="file_sound" />
			    </div>
			  </div>

			  @for ($i = 1; $i < 5; $i++)
			  <div class="form-group">
			    <label class="col-sm-2 control-label">答案{{$i}}</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="answers_txt[]" value="" />
			      <input type="file" title="上传图片"  name="answers_img[]" />
			      <input type="file" title="上传声音" name="answers_sound[]" />
			      <div class="checkbox">
				    <label>
				      <input type="checkbox" name="answers_right[]" /> 正确答案
				    </label>
				  </div>
			    </div>
			  </div>
			  @endfor

			  <div class="form-group">
			    <label class="col-sm-2 control-label">题目详解</label>
			    <div class="col-sm-10">
			      <textarea class="form-control" rows="3" name="disabuse"></textarea>
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="inputPassword" class="col-sm-3 control-label"></label>
			    <div class="col-sm-9">
			      	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delModal">删除用户</button>
			      	<button type="submit" class="btn btn-success">保存编辑</button>
			    </div>
			  </div>
			</form>

      	</div>
   	</div>

@stop

@section('js')
	<script src="/assets/bootstrap/js/bootstrap.file-input.js"></script>
	<script>
		$(document).ready(function(){
			$('input[type=file]').bootstrapFileInput();
		});
	</script>
@stop