@extends('Admin.master_column')
@section('title')浏览科目@stop

@section('nav')
  @include('Admin.subject.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
      <li class="active">浏览科目</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '科目名称', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '科目名称')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputDesc', '科目描述', array('class' => 'sr-only')) }}
        {{ Form::text('desc', $query['desc'], array('class' => 'form-control', 'id' => 'inputDesc', 'placeholder' => '科目描述')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputStatus', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputStatus')) }}
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
            <th>科目名称</th>
            <th>科目描述</th>
            <th>上线时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $subject)
          <tr>
            <td>{{$subject['id']}}</td>
            <td>{{$subject['name']}}</td>
            <td>{{$subject['description']}}</td>
            <td>{{$subject['online_at']}}</td>
            <td>
              @if ($subject['status'] == 1)
              <span class="label label-success">{{$statusEnum[$subject['status']]}}</span>
              @elseif ($subject['status'] == 0)
              <span class="label label-warning">{{$statusEnum[$subject['status']]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$subject['status']]}}</span>
              @endif
            </td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/subject/'. $subject['id'] .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="{{url('/admin/subject_item_relation/'. $subject['id'] .'/edit') }}"><i class="icon-asterisk"></i> 功能管理</a></li>
                      <li><a href="{{url('/admin/item_content?subject_id='. $subject['id']) }}"><i class="icon-magic"></i> 内容管理</a></li>
                      <li class="divider"></li>
                      @if($subject['status'] === 1)
                      <li class="disabled"><a href="#"><i class="icon-ok"></i> 发布</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$subject['id']}}" data-val="{{$subject['name']}}" data-status="-1"><i class="icon-trash"></i> 下线</a></li>
                      @elseif($subject['status'] === -1)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$subject['id']}}" data-val="{{$subject['name']}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                      <li class="disabled"><a href="#"><i class="icon-trash"></i> 下线</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$subject['id']}}" data-val="{{$subject['name']}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$subject['id']}}" data-val="{{$subject['name']}}" data-status="-1"><i class="icon-remove"></i> 下线</a></li>
                      @endif
                      <li class="divider"></li>
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$subject['id']}}" data-val="{{$subject['name']}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>

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

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'subject_id')) }}
    {{ Form::hidden('status', '', array('id' => 'subject_status')) }}
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

  //发布,下线
  $(".btn_publish").bind("click", function(){
      var $this = $(this);
      var subject_id = $this.data("id");
      var subject_val = $this.data("val");
      var subject_status = $this.data("status");
      if (subject_id <= 0) {
          alert("data error");
          return false;
      }
      if (subject_status == '1') {
        status_txt = '上线';
      } else if (subject_status == '-1') {
        status_txt = '下线';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要' + status_txt + ' '+subject_val+' 吗?');
      $("#subject_id").val(subject_id);
      $("#subject_status").val(subject_status);
      $("#myModalForm").attr('action', '{{ url('/admin/subject/') }}/' + subject_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var subject_id = $this.data("id");
      var subject_val = $this.data("val");
      if (subject_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+subject_val+' 吗?');
      $("#subject_id").val(subject_id);
      $("#myModalForm").attr('action', '/admin/subject/'+ subject_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop