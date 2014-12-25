@extends('Admin.master_column')
@section('title')查看所有评论@stop

@section('nav')
  @include('Admin.notice.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/notice">帮助反馈</a></li>
      <li class="active">查看所有评论</li>
    </ol>
  </div>
  
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputTel', '评论内容', array('class' => 'sr-only')) }}
        {{ Form::text('content', '', array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '评论内容')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>
  
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th style="width:135px;">{{ Form::checkbox('checkAll', 1,false, array('id' => 'checkAll')) }}</th>
            <th style="width:300px;">帮助公告</th>
            <th style="width:500px;">评论/回复内容</th>
            <th style="width:300px;">评论/回复</th>
            <th>用户</th>
            <th style="width:250px;">时间</th>
            <th style="width:250px;">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($comments as $k=>$v)
          <tr>
            <td>{{ Form::checkbox('commentid[]', $v->id) }}<label>&nbsp;{{$v->id}}</label></td>
            <td>
                <?php $notice=$v->notice; ?>
                <a href="/admin/notice/edit?id={{$v->notice_id}}" target="_blank">
                    @if(!empty($notice->type)){{$typeEnum[$notice->type]}}/@endif
                    {{$notice->title or ''}}
                </a>
            </td>
            <td>
           		<span style="display:inline-block;max-width:480px;word-wrap:break-word;">{{$v->content}}</span>
           	</td>
            <td>@if($v->cite)
            	回复@<span style="cursor:pointer;" 
					title="点击查看回复的评论内容"
            		onclick="showCiteInfo(event)" 
                	data-user="{{$v->cite->user->name or ''}}"
                	data-createdat="{{$v->cite->created_at}}"
            		data-content="{{htmlspecialchars($v->cite->content)}}">{{$v->cite->id}}</span>
            	@else
            	评论
            	@endif
            </td>
            <td>{{$v->user->name or '#'}}</td>
            <td>{{$v->created_at or ''}}</td>
            <td style="width:100px;">
			  <div class="btn-group btn-xs">
              	<a class="btn btn-default btn-xs" href="javascript:void(0);"><i class="icon-edit"></i> 操作</a>
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                <ul class="dropdown-menu">
	                <li>
	                	<a href="#" class="btn_reply" data-toggle="modal" data-id="{{$v->id}}" data-noticeid="{{$v->notice_id}}"  data-status="-1">
	                	<i class="icon-chevron-right"></i> 回复
	                	</a>
	                </li>
	                <li>
	                	<a href="#" class="btn_delete" data-toggle="modal" data-id="{{$v->id}}"  data-status="-1">
	                	<i class="icon-trash"></i> 删除
	                	</a>
	                </li>
                </ul>
        	  </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$comments->appends($query)->links()}}
  </div>
  <div class="col-md-12">
      {{ Form::button('批量删除', array('class' => 'btn btn-primary btn-xs pull-right', 'id' => 'deleteMany', 'style' => 'margin:10px')) }}
  </div>
  
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body" id="myModalBody">
        </div>
        <div class="modal-footer">
          {{ Form::button('取消', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
          {{ Form::button('确定', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
  
  <div class="modal fade" id="citeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="citeModalLabel">回复的评论</h4>
        </div>
        <div class="modal-body" id="citeModalBody">
        	<div>
        		<label>&nbsp;&nbsp;&nbsp;&nbsp;评论人：</label><span id="citeUser" style="margin-left:20px;"></span>
        	</div>
        	<div>
        		<label>评论时间：</label><span id="citeTime" style="margin-left:20px;"></span>
        	</div>
			<label>评论内容：</label>
			<div id="citeContent" style="width:550px;word-wrap:break-word;"></div>
        </div>
        <div class="modal-footer">
          {{ Form::button('关闭', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>

@stop

@section('js')
<script type="text/javascript">

function showCiteInfo(event) {
	var $cur = $(event.target);
	$('#citeUser').html($cur.data('user'));
	$('#citeTime').html($cur.data('createdat'));
	$('#citeContent').html($cur.data('content'));
    $('#citeModal').modal('show');
}

$(function(){

  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var $data_id = $this.data("id");
      if ($data_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#myModalForm").attr('action', '/admin/notice/doCommentDel?id='+ $data_id + '&tag=allcomment');
      $('#myModal').modal('show');
  });

  //回复
  $(".btn_reply").bind("click", function(){
	  var $this = $(this);
      var noticeid = $this.data('noticeid');
      var data_id = $this.data("id");
      if (noticeid <= 0 || data_id <= 0) {
          alert("data error");
          return false;
      }
      window.location.href = '/admin/notice/reply?commentid=' +data_id + '&noticeid=' + noticeid + '&tag=allcomment';
  });

  // 全选或全不选
  $("#checkAll").click(function() {
      $('input[name="commentid[]"]').prop("checked", this.checked);
  });

  // 批量删除
  $('#deleteMany').bind('click', function() {
	  var $item = $('input[name="commentid[]"]:checked');
	  if ($item.length <= 0) {
        alert('请选择评论后删除');
        return;
      }
	  var ids = new Array();
	  $item.each(function(){
		  ids.push($(this).val());
	  });
	  if(!confirm('您确定要批量删除吗？')){
		  return;
	  };
	  $.post("/admin/notice/doCommentDelMany", {
          ids: ids
      },
      function(data) {
        if(data.status == 1) {
            location.href = '/admin/notice/allcomment';
        } else {
        	alert('操作失败');
        	return;
        }
       },
      "json"
    )
    .fail(function(){
    	alert('操作失败');
    	return;
    });
  });
});
</script>
@stop
