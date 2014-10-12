@extends('Admin.master_column')
@section('title')科目内容管理@stop

@section('nav')
  @include('Admin.content_exam.nav')
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
      <li>
        {{link_to_route('admin.item_content.index', $subject['name'], array('subject_id' => $subject['id']))}}
      </li>
      <li>
        {{link_to_route('admin.subject_content.index', $subject_item['name'], array('subject_id' => $subject['id'],'subject_item_id' => $subject_item['id']))}}
      </li>
      <li>
        {{link_to_route('admin.subject_content.index', $subject_content['name'], array('subject_id' => $subject['id'],'subject_item_id' => $subject_item['id']))}}
      </li>
      <li class="active">浏览内容</li>
    </ol>
  </div>
  <div class="row text-right">{{$paginator->links()}}</div>
  <div class="row">
    <div class="col-md-5">
      <div class="panel panel-primary">
        <div class="panel-heading">选择题库</div>
        <div class="panel-body">题库列表...</div>
      </div>
    </div>
    <div class="col-md-1">
      <p class="text-center">>></p>
    </div>
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">试题列表</div>
        <div class="panel-body">
          <ol>
            @foreach ($exams as $exam)
            <li>{{$exam->txt}}</li>
            @endforeach
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-right">{{$paginator->links()}}</div>

</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'subject_content_id')) }}
    {{ Form::hidden('status', '', array('id' => 'subject_content_status')) }}
    {{ Form::hidden('_method', '', array('id' => 'form_method')) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body" id="myModalBody"></div>
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