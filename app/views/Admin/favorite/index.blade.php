@extends('Admin.master_column')
@section('title')我的收藏@stop

@section('nav')
  @include('Admin.favorite.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.favorite.index', '我的收藏')}}</li>
      <li class="active">浏览收藏</li>
    </ol>
  </div>

  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>收藏者</th>
            <th>题目ID</th>
            <th>题干</th>
            <th>题目类型</th>
            <th>收藏时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->user->name}}</td>
            <td>{{$list->question_id}}</td>
            <td>{{$list->question->txt}}</td>
            <td>{{$list->question->type}}</td>
            <td>{{$list->created_at}}</td>
            <td>
              <div class="btn-group btn-xs">
                <a class="btn btn-default btn-xs btn_delete" href="#" data-toggle="modal" data-id="{{$list->id}}"><i class="glyphicon glyphicon-remove"></i></a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$lists->appends($query)->links()}}
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'favorite_id')) }}
    {{ Form::hidden('_method', '', array('id' => 'form_method')) }}

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
      var favorite_id = $this.data("id");
      if (favorite_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#favorite_id").val(favorite_id);
      $("#myModalForm").attr('action', '/admin/favorite/'+ favorite_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop