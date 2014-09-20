@extends('Admin.master_column')
@section('title')浏览用户@stop

@section('nav')
  @include('Admin.user.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.user.index', '用户管理')}}</li>
      <li class="active">浏览用户</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '用户名', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '用户名')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '手机号', array('class' => 'sr-only')) }}
        {{ Form::text('tel', $query['tel'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '手机号')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputStatus', '类型', array('class' => 'sr-only')) }}
        {{ Form::select('type', $typeEnum, $query['type'], array('class' => 'form-control', 'id' => 'inputType')) }}
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
            <th>用户名</th>
            <th>手机号</th>
            <th>类型</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $user)
          <tr>
            <td>{{$user['id']}}</td>
            <td>{{$user['name']}}</td>
            <td>{{$user['tel']}}</td>
            <td>{{$typeEnum[$user['type']]}}</td>
            <td>{{$statusEnum[$user['status']]}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/user/'. $user['id'] .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      @if($user['status'] === 1)
                      <li><a style='color:#999;'><i class="icon-ok"></i> 有效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="0"><i class="icon-remove"></i> 无效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="-1"><i class="icon-remove"></i> 审核未通过</a></li>
                      @elseif($user['status'] === 0)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="1"><i class="icon-ok"></i> 有效</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 无效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="-1"><i class="icon-remove"></i> 审核未通过</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="1"><i class="icon-ok"></i> 有效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="0"><i class="icon-remove"></i> 无效</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 审核未通过</a></li>
                      @endif
                      <li class="divider"></li>
                      @if($user['name'] === 'admin')
                      <li><a style='color:#999;'><i class="icon-trash"></i> 删除</a></li>
                      @else
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$user['id']}}" data-val="{{$user['name']}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>
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

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('id', '', array('id' => 'user_id')) }}
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
      $("#myModalBody").html('你确定要把'+user_val+'设置成' + status_txt + '吗?');
      $("#user_id").val(user_id);
      $("#user_status").val(user_status);
      $("#myModalForm").attr('action', '{{ url('/admin/user/') }}/' + user_id);
      $("#form_method").attr('value', 'PUT');
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
      $("#myModalBody").html('你确定要删除 '+user_val+' 吗?');
      $("#user_id").val(user_id);
      $("#myModalForm").attr('action', '/admin/user/'+ user_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop