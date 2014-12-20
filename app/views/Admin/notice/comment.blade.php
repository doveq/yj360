@extends('Admin.master_column')
@section('title')帮助反馈@stop

@section('nav')
  @include('Admin.notice.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/notice">帮助反馈</a></li>
      <li class="active">查看评论</li>
    </ol>
  </div>
  
  <div class="row" style="margin-bottom:10px;">
	<span style="font-weight:bold;">帮助标题：</span>
	<a href="{{url('/admin/notice/edit?id='.$noticeinfo->id)}}" target="_blank">{{$noticeinfo->title}}</a>
  </div>

  <div class="row">
      <table class="table table-hover" style="width:800px">
        <thead>
          <tr>
            <th>#</th>
            <th>内容</th>
            <th>回复/评论</th>
            <th>用户</th>
            <th>时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($comments as $k=>$v)
          <tr>
            <td>{{$v->id}}</td>
            <td>
           		<span style="display:inline-block;max-width:400px;word-wrap:break-word;">{{$v->content}}</span>
           	</td>
            <td>@if($v->cite)
            	回复@<span style="cursor:pointer;" 
					title="点击查看回复的评论内容"
            		onclick="showCiteInfo(event)" 
                	data-user="{{$v->cite->user->name or ''}}"
                	data-createdat="{{$v->cite->created_at}}"
            		data-content="{{htmlspecialchars($v->cite->content)}}">
            		{{$v->cite->id}}
            	</span>
            	@else
            	评论
            	@endif
            </td>
            <td>{{$v->user->name}}</td>
            <td>{{$v->created_at or ''}}</td>
            <td style="width:150px;">
			  <div class="btn-group btn-xs">
              	<a class="btn btn-default btn-xs" href="javascript:void(0);"><i class="icon-edit"></i> 操作</a>
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                <ul class="dropdown-menu">
	                <li>
	                	<a href="#" class="btn_reply" data-toggle="modal" data-id="{{$v->id}}"  data-status="-1">
	                	<i class="icon-chevron-right"></i> 回复评论
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
      $("#myModalForm").attr('action', '/admin/notice/doCommentDel?id='+ $data_id + "&noticeid=" + {{$query['id']}});
      $('#myModal').modal('show');
  });

  //回复
  $(".btn_reply").bind("click", function(){
	  var $this = $(this);
      var noticeid = '{{$noticeinfo->id}}';
      var data_id = $this.data("id");
      if (data_id <= 0) {
          alert("data error");
          return false;
      }
      window.location.href = '/admin/notice/reply?commentid=' + data_id + '&noticeid=' + noticeid;
  });
});
</script>
@stop
