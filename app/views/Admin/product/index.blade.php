@extends('Admin.master_column')
@section('title')浏览产品@stop

@section('nav')
  @include('Admin.product.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.product.index', '产品管理')}}</li>
      <li class="active">浏览产品</li>
    </ol>
  </div>
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <div class="form-group">
        {{ Form::label('inputName', '产品名称', array('class' => 'sr-only')) }}
        {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '产品名称')) }}
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
          <th>产品名称</th>
          <!-- <th>产品图片</th> -->
          <th>价格</th>
          <th>有效期</th>
          <th>策略</th>
          <th>上线时间</th>
          <th>科目</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($lists as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td>{{$list->name}}</td>
          <td>{{$list->price}}</td>
          <td>{{$list->valid_period}}</td>
          <td>{{$policyEnum[$list->policy]}}</td>
          <td> @if ($list->online_at) {{$list->online_at}} @endif</td>
          <td>{{$list->column->name}}</td>
          <td>
            @if ($list->status == 1)
            <span class="label label-success">{{$statusEnum[$list->status]}}</span>
            @elseif ($list->status == 0)
            <span class="label label-warning">{{$statusEnum[$list->status]}}</span>
            @else
            <span class="label label-default">{{$statusEnum[$list->status]}}</span>
            @endif
          </td>
          <td>
            <div class="btn-group btn-xs">
                <a class="btn btn-default btn-xs" href="{{url('/admin/product/'. $list->id .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                <ul class="dropdown-menu">
                    @if($list->status === 1)
                    <li><a style='color:#999;'><i class="icon-ok"></i> 发布</a></li>
                    <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-trash"></i> 下线</a></li>
                    @elseif($list->status === -1)
                    <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                    <li><a style='color:#999;'><i class="icon-trash"></i> 下线</a></li>
                    @else
                    <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                    <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-remove"></i> 下线</a></li>
                    @endif
                    <li class="divider"></li>
                    <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>
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
    {{ Form::hidden('id', '', array('id' => 'product_id')) }}
    {{ Form::hidden('status', '', array('id' => 'product_status')) }}
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
      var product_id = $this.data("id");
      var product_val = $this.data("val");
      var product_status = $this.data("status");
      if (product_id <= 0) {
          alert("data error");
          return false;
      }
      if (product_status == '1') {
        status_txt = '上线';
      } else if (product_status == '-1') {
        status_txt = '下线';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要' + status_txt + ' '+product_val+' 吗?');
      $("#product_id").val(product_id);
      $("#product_status").val(product_status);
      $("#myModalForm").attr('action', '{{ url('/admin/product/') }}/' + product_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var product_id = $this.data("id");
      var product_val = $this.data("val");
      if (product_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 '+product_val+' 吗?');
      $("#product_id").val(product_id);
      $("#myModalForm").attr('action', '/admin/product/'+ product_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop