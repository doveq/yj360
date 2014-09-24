@extends('Admin.master')

@section('title')添加题目@stop

@section('css')
	<link href="/assets/mediaelement/build/mediaelementplayer.min.css" rel="stylesheet">
@stop
@section('headjs')
	<script src="/assets/mediaelement/build/mediaelement-and-player.min.js"></script>
@stop

@section('content')
    <div class="container theme-showcase" role="main">
      	<div class="row">
      		@if(isset($is_edit))
      		<form class="form-horizontal" role="form" action="/admin/topic/doEdit" method="post" enctype="multipart/form-data">
      		<input type="hidden" name="qid" value="{{$q['id']}}" />
      		@else
      		<form class="form-horizontal" role="form" action="/admin/topic/doAdd" method="post" enctype="multipart/form-data">
      		@endif

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
			      <input type="text" class="form-control" name="txt" value="{{$q['txt'] or ''}}" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">题干图片</label>
			    <div class="col-sm-10">
			      @if(isset($q['img_url']))
		      	  <div>
			      	<input type="hidden" name="file_img_id" value="{{$q['img_att_id']}}" />
			      	<img src="{{$q['img_url']}}" />
		      	  </div>
			      @endif
			      <input type="file" title="选择上传" name="file_img" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">提干音</label>
			    <div class="col-sm-10">
			      @if(isset($q['sound_url']))
			      <div>
			      	<input type="hidden" name="file_sound_id" value="{{$q['sound_att_id']}}" />
			      	<audio src="{{$q['sound_url']}}">
			      </div>
			      @endif
			      <input type="file" title="选择上传" name="file_sound" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">提示音</label>
			    <div class="col-sm-10">
			      @if(isset($q['hint_url']))
			      <div>
			      	<input type="hidden" name="file_hint_id" value="{{$q['hint_att_id']}}" />
			      	<audio src="{{$q['hint_url']}}">
			      </div>
			      @endif
			      <input type="file" title="选择上传" name="file_hint" />
			    </div>
			  </div>

			  

			  @for ($i = 0; $i < 4; $i++)
			  <div class="form-group">
			    <label class="col-sm-2 control-label">答案{{$i}}</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="answers_txt[]" value="{{$a[$i]['txt'] or ''}}" />
			      @if(isset($a[$i]['img_url']))
			      <div>
			      	<input type="hidden" name="answers_img_id[]" value="{{$a[$i]['img_att_id']}}" />
			      	<img src="{{$a[$i]['img_url']}}" />
			      </div>
			      @endif
			      @if(isset($a[$i]['sound_url']))
			      <div>
			      	<input type="hidden" name="answers_sound_id[]" value="{{$a[$i]['sound_att_id']}}" />
			      	<audio src="{{$a[$i]['sound_url']}}">
			      </div>
			      @endif
			      <input type="file" title="上传图片"  name="answers_img[]" />
			      <input type="file" title="上传声音" name="answers_sound[]" />
			      <div class="checkbox">
				    <label>
				      @if(isset($a[$i]['is_right']) && $a[$i]['is_right'])
				      <input type="checkbox" name="answers_right[]" checked="checked" value="1" /> 正确答案
				      @else
				      <input type="checkbox" name="answers_right[]" value="1" /> 正确答案
				      @endif
				    </label>
				  </div>
			    </div>
			  </div>
			  @endfor

			  <div class="form-group">
			    <label class="col-sm-2 control-label">题目详解</label>
			    <div class="col-sm-10">
			      <textarea class="form-control" rows="3" name="disabuse">{{$q['disabuse'] or ''}}</textarea>
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="inputPassword" class="col-sm-3 control-label"></label>
			    <div class="col-sm-9">
			      	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delModal">删除</button>
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
			$('audio,video').mediaelementplayer();
		});
	</script>
@stop