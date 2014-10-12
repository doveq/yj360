@extends('Admin.master_column')
@section('title')科目内容管理@stop

@section('nav')
  @include('Admin.subject_content.nav')
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      <ol class="breadcrumb">
        <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
        <li>{{link_to_route('admin.item_content.index', $subject['name'], array('subject_id' => $subject['id']))}}</li>
        <li>{{link_to_route('admin.subject_content.index', $subject_item['name'], array('subject_id' => $subject['id'],'subject_item_id' => $subject_item['id']))}}</li>
        <li class="active">浏览内容</li>
{{link_to_route('admin.subject_content.create', '添加内容', array('subject_id' => $subject['id'],'subject_item_id' => $subject_item['id']),array('class' => 'btn btn-primary btn-xs pull-right'))}}
      </ol>
    </div>
    <div class="row text-right">
        {{$paginator->links()}}
    </div>
    <div class="row">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>项目名称</th>
              <th>状态</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($contents as $item)
            <tr>
              <td>{{$item['id']}}</td>
              <td>{{$item['name']}}</td>
              <td>
                @if ($item['status'] == 1)
                <span class="label label-success">{{$statusEnum[$item['status']]}}</span>
                @elseif ($item['status'] == 0)
                <span class="label label-warning">{{$statusEnum[$item['status']]}}</span>
                @else
                <span class="label label-default">{{$statusEnum[$item['status']]}}</span>
                @endif
              </td>
              <td>
                <div class="btn-group btn-xs">
                    <a class="btn btn-default btn-xs" href="{{ url('/admin/subject_content/'.$item['id'].'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                    <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/admin/content_exam?subject_content_id='. $item['id']) }}"><i class="icon-magic"></i> 内容管理</a></li>
                      <li class="divider"></li>
                      @if($item['status'] === 1)
                      <li><a style='color:#999;'><i class="icon-ok"></i> 发布</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$item['id']}}" data-val="{{$item['name']}}" data-status="-1"><i class="icon-trash"></i> 下线</a></li>
                      @elseif($item['status'] === -1)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$item['id']}}" data-val="{{$item['name']}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                      <li><a style='color:#999;'><i class="icon-trash"></i> 下线</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$item['id']}}" data-val="{{$item['name']}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$item['id']}}" data-val="{{$item['name']}}" data-status="-1"><i class="icon-remove"></i> 下线</a></li>
                      @endif
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

  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'subject_content_id')) }}
    {{ Form::hidden('status', '', array('id' => 'subject_content_status')) }}
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
      var subject_content_id = $this.data("id");
      var subject_content_val = $this.data("val");
      var subject_content_status = $this.data("status");
      if (subject_content_id <= 0) {
          alert("data error");
          return false;
      }
      if (subject_content_status == '1') {
        status_txt = '上线';
      } else if (subject_content_status == '-1') {
        status_txt = '下线';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要' + status_txt + ' '+subject_content_val+' 吗?');
      $("#subject_content_id").val(subject_content_id);
      $("#subject_content_status").val(subject_content_status);
      $("#myModalForm").attr('action', '{{ url('/admin/subject_content/') }}/' + subject_content_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });

});
</script>
@stop