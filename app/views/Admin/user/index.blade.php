@extends('Admin.master_column')
@section('title')用户管理@stop

@section('nav')
  @include('Admin.user.nav')
@stop

@section('css')
  <link href="/assets/lightbox/css/lightbox.css" rel="stylesheet" />
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
        {{ Form::label('inputType', '类型', array('class' => 'sr-only')) }}
        {{ Form::select('type', $typeEnum, $query['type'], array('class' => 'form-control', 'id' => 'inputType')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputStatus', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputStatus')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
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
            <th>注册时间</th>
            <th>最后登陆时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td>{{$list->name}}</td>
            <td>{{substr($list->tel,0,3). '****' .substr($list->tel,7,4)}}</td>
            <td>

                {{$typeEnum[$list->type]}}
                @if($list->is_certificate == 1)
                  <a href="{{$list->certificate}}" data-lightbox="image-{{$list->id}}" data-title="{{$list->name}}教师证"><span class="icon-credit-card"></span></a>
                @endif

            </td>
            <td>
              @if ($list->status == 1)
              <span class="label label-success">{{$statusEnum[$list->status]}}</span>
              @elseif ($list->status == 0)
              <span class="label label-warning">{{$statusEnum[$list->status]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$list->status]}}</span>
              @endif
            </td>
            <td>{{$list->created_at}}</td>
            <td>{{$list->updated_at}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/user/'. $list->id .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      @if($list->status === 1)
                      <li><a style='color:#999;'><i class="icon-ok"></i> 审核通过</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="0"><i class="icon-user-md"></i> 未审核</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-remove"></i> 锁定</a></li>
                      @elseif($list->status === 0)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 审核通过</a></li>
                      <li><a style='color:#999;'><i class="icon-user-md"></i> 未审核</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-remove"></i> 锁定</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 审核通过</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="0"><i class="icon-user-md"></i> 未审核</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 锁定</a></li>
                      @endif
                      <li class="divider"></li>
                      @if($list->name === 'admin')
                      <li><a style='color:#999;'><i class="icon-trash"></i> 删除</a></li>
                      @else
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>
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
      {{$lists->appends($query)->links()}}
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
<script src="/assets/lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">

$(function(){

  //发布,下线
  $(".btn_publish").on("click", function(){
      var $this = $(this);
      var user_id = $this.data("id");
      var user_val = $this.data("val");
      var user_status = $this.data("status");
      if (user_id <= 0) {
          alert("data error");
          return false;
      }
      if (user_status == '1') {
        status_txt = '审核通过';
      } else if (user_status == '0') {
        status_txt = '未审核';
      } else {
        status_txt = '锁定';
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