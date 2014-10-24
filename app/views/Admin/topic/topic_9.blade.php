@extends('Admin.master')

@section('title')题目编辑@stop

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

      		<input type="hidden" id="type" name="type" value="{{$type}}" />
      		 @include('Admin.topic.topic_type')
      		 <div class="form-group">
      		 	<label class="col-sm-2 control-label">题库</label>
      		 	<div class="col-sm-10" id="sort">
			    {{Form::select('sort1', array(), '', array('class' => 'sort1', 'data-value' => $sort1))}}
			    {{Form::select('sort2', array(), '', array('class' => 'sort2', 'data-value' => $sort2))}}
			    {{Form::select('sort3', array(), '', array('class' => 'sort3', 'data-value' => $sort3))}}
			    {{Form::select('sort4', array(), '', array('class' => 'sort4', 'data-value' => $sort4))}}
			    {{Form::select('sort5', array(), '', array('class' => 'sort5', 'data-value' => $sort5))}}
			  	</div>
			  </div>

      		  <div class="form-group">
			    <label class="col-sm-2 control-label">原始编号</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="source" value="{{$q['source'] or ''}}" />
			    </div>
			  </div>


			  <div class="form-group">
			    <label class="col-sm-2 control-label">题干</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="txt" value="{{$q['txt'] or ''}}" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">题干图片(TP)</label>
			    <div class="col-sm-10">
			      @if(isset($q['img_url']))
		      	  <div>
			      	<input type="hidden" name="file_img_id" value="{{$q['img_att_id']}}"  />
			      	<img src="{{$q['img_url']}}" />
		      	  </div>
		      	  <div class="checkbox">
				    <label>
				      <input type="checkbox" name="del_img" value="{{$q['img_att_id']}}" /> 删除题干图片
				    </label>
				  </div>
			      @endif
			      <input type="file" title="选择上传" name="file_img" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">flash</label>
			    <div class="col-sm-10">
			      @if(isset($q['flash_url']))
			      <div>
			      	<input type="hidden" name="file_flash_id" value="{{$q['flash_att_id']}}" />
			      </div>
			      <div class="checkbox">
				    <label>
				      <input type="checkbox" name="del_flash" value="{{$q['flash_att_id']}}" /> 删除flash
				    </label>
				  </div>
			      @endif
			      <input type="file" title="选择上传" name="file_flash" />
			    </div>
			  </div>

			  <div class="form-group" style="display:none;">
			    <label class="col-sm-2 control-label">提干音(TM)</label>
			    <div class="col-sm-10">
			      @if(isset($q['sound_url']))
			      <div>
			      	<input type="hidden" name="file_sound_id" value="{{$q['sound_att_id']}}" />
			      	<audio src="{{$q['sound_url']}}">
			      </div>
			      <div class="checkbox">
				    <label>
				      <input type="checkbox" name="del_sound" value="{{$q['sound_att_id']}}" /> 删除提干音
				    </label>
				  </div>
			      @endif
			      <input type="file" title="选择上传" name="file_sound" />
			    </div>
			  </div>

			  <div class="form-group" style="display:none;">
			    <label class="col-sm-2 control-label">提干提示音(TS)</label>
			    <div class="col-sm-10">
			      @if(isset($q['hint_url']))
			      <div>
			      	<input type="hidden" name="file_hint_id" value="{{$q['hint_att_id']}}" />
			      	<audio src="{{$q['hint_url']}}">
			      </div>
			      <div class="checkbox">
				    <label>
				      <input type="checkbox" name="del_hint" value="{{$q['hint_att_id']}}" /> 删除提示音
				    </label>
				  </div>
			      @endif
			      <input type="file" title="选择上传" name="file_hint" />
			    </div>
			  </div>

			  <?php
			  		$answersBox = "";
			  ?>

			  @for ($i = 0; $i < 4; $i++)
			  <div class="form-group"  style="display:none;">
			    <label class="col-sm-2 control-label">答案{{$flag[$i]}}</label>
			    <div class="col-sm-10">
			      @if(isset($a[$i]['id']))
			      	<input type="hidden" name="aid[]" value="{{$a[$i]['id']}}" />
			      @endif

			      <input type="text" class="form-control" name="answers_txt[]" value="{{$a[$i]['txt'] or ''}}" />
			      
			      @if(isset($a[$i]['img_url']))
			      <div>
			      	<input type="hidden" name="answers_img_id[]" value="{{$a[$i]['img_att_id']}}" />
			      	<img src="{{$a[$i]['img_url']}}" />
			      </div>
			      <div class="checkbox">
				    <label>
				      <input type="checkbox" name="del_answers_img[]" value="{{$a[$i]['img_att_id']}}" /> 删除答案图片
				    </label>
				  </div>
			      @endif
			      @if(isset($a[$i]['sound_url']))
			      <div>
			      	<input type="hidden" name="answers_sound_id[]" value="{{$a[$i]['sound_att_id']}}" />
			      	<audio src="{{$a[$i]['sound_url']}}">
			      </div>
			      <div class="checkbox">
				    <label>
				      <input type="checkbox" name="del_answers_sound[]" value="{{$a[$i]['sound_att_id']}}" /> 删除答案声音
				    </label>
				  </div>
			      @endif
			      <input type="file" title="上传图片({{$flag[$i]}}P)"  name="answers_img[]" />
			      <input type="file" title="上传声音({{$flag[$i]}}M)" name="answers_sound[]" />

			      <?php

			      	$v = isset($a[$i]["id"]) ? $a[$i]["id"] : 0;
			  		$answersBox .= '<span style="padding:0 10px;width:auto;"><label>';

					if(isset($a[$i]['is_right']) && $a[$i]['is_right'])
						$answersBox .= "<input class='abox' type='checkbox' name='answers_right[]' checked='checked' value='$v' /> $flag[$i]";
					else
					   	$answersBox .= "<input class='abox' type='checkbox' name='answers_right[]' value='$v' /> $flag[$i]";

					    
					$answersBox .= '</label></span>';
				  ?>

			    </div>
			  </div>
			  @endfor

			  <div class="form-group"  style="display:none;">
			    <label class="col-sm-2 control-label">正确答案</label>
			    <div class="col-sm-10" id="answers-box">
			    	<?php echo $answersBox; ?>
			    </div>
			  </div>

			  <div class="form-group"  style="display:none;">
			    <label class="col-sm-2 control-label">题目详解</label>
			    <div class="col-sm-10">
			      <textarea rows="3" id="disabuse" name="disabuse">{{$q['disabuse'] or ''}}</textarea>
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">作者</label>
			    <div class="col-sm-10">
			      	<input type="text" class="form-control" name="author" value="{{$q['author'] or ''}}" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label class="col-sm-2 control-label">介绍</label>
			    <div class="col-sm-10">
			      	<input type="text" class="form-control" name="intro" value="{{$q['intro'] or ''}}" />
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="inputPassword" class="col-sm-3 control-label"></label>
			    <div class="col-sm-9">
			      	<button type="submit" class="btn btn-success">提交保存</button>
			    </div>
			  </div>
			</form>

      	</div>
   	</div>

@stop

@section('js')
	<script src="/assets/bootstrap/js/bootstrap.file-input.js"></script>
    <script type="text/javascript" src="/assets/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/assets/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>
    {{ HTML::script('/assets/jquery.cxselect.min.js') }}

	<script>
		
		$(document).ready(function(){
			$('input[type=file]').bootstrapFileInput();
			$('audio,video').mediaelementplayer();

			if($('#type').val() == 1)
			{
				$('.abox').click(function(){
					$('.abox').prop("checked", false);
					$(this).prop("checked", true);
				});
			}

			$.cxSelect.defaults.url = '/admin/column.json';
			$('#sort').cxSelect({
			      url:'/admin/sort.json',
			      firstTitle: '-请选择-分类-',
			      selects: ['sort1', 'sort2', 'sort3', 'sort4', 'sort5'],
			      nodata: 'none'
			  });

			UE.getEditor('disabuse');

			$(".form-horizontal").submit(function(){
				if($('input[name=txt]').val() == "" || $('select[name=sort1]').val() == 0)
				{
					alert("题库和题干必须选择和填写");
					return false;
				}
				else
					return true;
			});
		});
	</script>
@stop