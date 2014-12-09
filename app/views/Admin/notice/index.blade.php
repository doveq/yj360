@extends('Admin.master_column')
@section('title')帮助反馈@stop

@section('nav')
  @include('Admin.notice.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/notice">帮助反馈</a></li>
      <li class="active">浏览消息</li>
    </ol>
  </div>

  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '标题', array('class' => 'sr-only')) }}
        {{ Form::text('title', $query['title'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '标题')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputType', '类型', array('class' => 'sr-only')) }}
        {{ Form::select('type', $typeEnum, $query['type'], array('class' => 'form-control', 'id' => 'inputType')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>

  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>标题</th>
            <th>创建时间</th>
            <th>类型</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $v)
          <tr>
            <td>{{$v->id}}</td>
            <td><a href="{{url('/admin/notice/edit?id='.$v->id)}}">{{$v->title}}</a></td>
            <td>{{$v->created_at}}</td>
            <td>
              {{$typeEnum[$v->type]}}
            </td>
            <td>
              <div class="btn-group btn-xs">
                <a class="btn btn-default btn-xs btn_delete" href="#" data-toggle="modal" data-id="{{$v->id}}" data-status="-1"><i class="glyphicon glyphicon-remove"></i></a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$list->appends($query)->links()}}
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

@stop

@section('js')
<script type="text/javascript">

$(function(){

  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var feedback_id = $this.data("id");
      if (feedback_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#myModalForm").attr('action', '/admin/notice/doDel?id='+ feedback_id);
      $('#myModal').modal('show');
  });
});
</script>
@stop