@extends('Admin.master_column')
@section('title')科目管理@stop

@section('nav')
  @include('Admin.column.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
      @if ($query['parent_id'] > 0)
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      @endif
      <li class="active">浏览科目</li>
      @if ($query['parent_id'] > 0)
      <a href="{{url('/admin/column?parent_id='.$parent->parent_id)}}"><span class='pull-right  icon-arrow-up'> 返回上级</span></a>
      @endif
    </ol>
  </div>

  <div class="row">
      <div class="col-md-4 col-md-offset-8 text-right">
        {{ link_to_route('admin.column.create', ' 添加内容', array('parent_id' => $query['parent_id']), array('class' => 'btn btn-success')) }}
        {{ link_to_route('admin.column.create', ' 添加同级分类', array('parent_id' => $query['parent_id']), array('class' => 'btn btn-primary')) }}
      </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>名称</th>
            <th>图片</th>
            <th>描述</th>
            <th>上线时间</th>
            <th>状态</th>
            <th>素材类型</th>
            <th>查看题目</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td><a href="{{url('/admin/column?parent_id='. $list->id) }}">{{$list->name}}</a></td>
            <td>
              @if ($list->thumbnail)
              <img src="{{Config::get('app.thumbnail_url')}}/{{$list->thumbnail}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
              @endif
            </td>
            <td>{{$list->desc}}</td>
            <td>{{$list->online_at}}</td>
            <td>
              @if ($list->status == 1)
              <span class="label label-info">{{$statusEnum[$list->status]}}</span>
              @elseif ($list['status'] == 0)
              <span class="label label-warning">{{$statusEnum[$list->status]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$list->status]}}</span>
              @endif
            </td>
            <td>{{$typeEnum[$list->type]}}</td>
            <td><a href="/admin/questions?type=column&id={{$list->id}}" target="_blank">查看</a></td>
            <td>
              <div class="btn-group btn-xs">
                <a class="btn btn-default btn-xs" href="{{url('/admin/column/'. $list->id .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/admin/column?parent_id='. $list->id) }}"><i class="icon-magic"></i> 内容管理</a></li>
                    <li><a href="{{url('/admin/column/create?parent_id='. $list->id) }}"><i class="icon-plus-sign"></i> 新建子科目</a></li>
                    <li><a href="{{url('/admin/product/create?column_id='. $list->id) }}"><i class="icon-star-empty"></i> 打包成产品</a></li>
                    <li class="divider"></li>
                    @if($list->status === 1)
                    <li class="disabled"><a href="#"><i class="icon-ok"></i> 发布</a></li>
                    <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="-1"><i class="icon-trash"></i> 下线</a></li>
                    @elseif($list->status === -1)
                    <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$list->id}}" data-val="{{$list->name}}" data-status="1"><i class="icon-ok"></i> 发布</a></li>
                    <li class="disabled"><a href="#"><i class="icon-trash"></i> 下线</a></li>
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
    {{ Form::hidden('id', '', array('id' => 'column_id')) }}
    {{ Form::hidden('status', '', array('id' => 'column_status')) }}
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
      var column_id = $this.data("id");
      var column_status = $this.data("status");
      if (column_id <= 0) {
          alert("data error");
          return false;
      }
      if (column_status == '1') {
        status_txt = '发布';
      } else if (column_status == '-1') {
        status_txt = '下线';
      } else {
        status_txt = '准备';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要设置成' + status_txt + '吗?');
      $("#column_id").val(column_id);
      $("#column_status").val(column_status);
      $("#myModalForm").attr('action', '{{ url('/admin/column/') }}/' + column_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var column_id = $this.data("id");
      if (column_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#column_id").val(column_id);
      $("#myModalForm").attr('action', '/admin/column/'+ column_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop
