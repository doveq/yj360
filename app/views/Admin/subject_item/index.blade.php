@extends('Admin.master_column')
@section('title')浏览科目功能@stop

@section('nav')
  @include('Admin.subject_item.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
      <li class="active">浏览科目功能项</li>
    </ol>
  </div>
  <div class="row text-right">
      {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
        <div class="form-group">
          {{ Form::label('inputName', '功能名称', array('class' => 'sr-only')) }}
          {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '功能名称')) }}
        </div>
        {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
      {{ Form::close() }}
  </div>

  <div class="row text-right">
      {{$paginator->links()}}
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>功能名称</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $subject_item)
          <tr>
            <td>{{$subject_item['id']}}</td>
            <td>{{$subject_item['name']}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{ url('/admin/subject_item/' . $subject_item['id'] . '/edit') }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                    <li><a class="btn_delete" data-toggle="modal" data-id="{{$subject_item['id']}}" data-val="{{$subject_item['name']}}"><i class="icon-trash"></i> 删除</a></li>
                  </ul>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$paginator->links()}}
  </div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
  {{ Form::hidden('name', '', array('id' => 'subject_item_id')) }}
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
      var subject_item_id = $this.data("id");
      var subject_item_val = $this.data("val");
      if (subject_item_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+subject_item_val+' 吗?');
      $("#subject_item_id").val(subject_item_id);
      $("#myModalForm").attr('action', '/admin/subject_item/'+ subject_item_id);
      $("#form_method").attr('value', 'DELETE');
      $('#delModal').modal('show');
  });
});
</script>
@stop