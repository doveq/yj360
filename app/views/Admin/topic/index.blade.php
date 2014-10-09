@extends('Admin.master_column')
@section('title')真题题库@stop

@section('nav')
  <div class="list-group">
    <a href="topic" class="list-group-item @if(!isset($query['type'])) active @endif ">所有类型</a>
    @foreach($typeEnum as $k => $v)
      <a href="topic?type={{$k}}" class="list-group-item @if(isset($query['type']) && $query['type'] == $k) active @endif ">{{$v}}</a>
    @endforeach
  </div>
@stop

@section('content')
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '题干', array('class' => 'sr-only')) }}
        {{ Form::text('txt', $query['txt'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '题干')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '原始编号', array('class' => 'sr-only')) }}
        {{ Form::text('source', $query['source'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '原始编号')) }}
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
            <th>题干</th>
            <th>原始编号</th>
            <th>状态</th>
            <th>添加时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $info)
          <tr>
            <td>{{$info['id']}}</td>
            <td>{{$info['txt']}}</td>
            <td>{{$info['source']}}</td>
            <td>{{$statusEnum[$info['status']]}}</td>
            <td>{{$info['created_at']}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/topic/edit?id='. $info['id']) }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      @if($info['status'] === 1)
                      <li><a style='color:#999;'><i class="icon-ok"></i> 有效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="0"><i class="icon-remove"></i> 无效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="-1"><i class="icon-remove"></i> 审核未通过</a></li>
                      @elseif($info['status'] === 0)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="1"><i class="icon-ok"></i> 有效</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 无效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="-1"><i class="icon-remove"></i> 审核未通过</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="1"><i class="icon-ok"></i> 有效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="0"><i class="icon-remove"></i> 无效</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 审核未通过</a></li>
                      @endif
                      <li class="divider"></li>
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>
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
    {{ Form::hidden('qid', '', array('id' => 'user_id')) }}
    {{ Form::hidden('status', '', array('id' => 'user_status')) }}
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
      var user_id = $this.data("id");
      var user_val = $this.data("val");
      var user_status = $this.data("status");
      if (user_id <= 0) {
          alert("data error");
          return false;
      }
      if (user_status == '1') {
        status_txt = '有效';
      } else if (user_status == '0') {
        status_txt = '无效';
      } else {
        status_txt = '审核未通过';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要把#'+user_val+'设置成' + status_txt + '吗?');
      $("#user_id").val(user_id);
      $("#user_status").val(user_status);
      $("#myModalForm").attr('action', '{{ url('/admin/topic/doEdit') }}');
      $("#form_method").attr('value', 'post');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var user_id = $this.data("id");
      var user_val = $this.data("val");
      if (user_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 #'+user_val+' 吗?');
      $("#myModalForm").attr('action', '/admin/topic/doDel?qid='+ user_id);
      $("#form_method").attr('value', 'get');
      $('#myModal').modal('show');
  });
});
</script>
@stop