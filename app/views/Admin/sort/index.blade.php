@extends('Admin.master_column')
@section('title')题库分类@stop

@section('nav')
  @include('Admin.sort.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.sort.index', '题库分类管理')}}</li>
      @if ($query['parent_id'] > 0)
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.sort.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      @endif
      <li class="active">浏览分类</li>
      @if ($query['parent_id'] > 0)
      <a href="{{url('/admin/sort?parent_id='.$parent->parent_id)}}"><span class='pull-right  icon-arrow-up'> 返回上级</span></a>
      @endif
    </ol>

  </div>

  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>名称</th>
            <th>图片</th>
            <th>描述</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>查看题目</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lists as $list)
          <tr>
            <td>{{$list->id}}</td>
            <td><a href="{{url('/admin/sort?parent_id='. $list->id) }}">{{$list->name}}</a></td>
            <td>
              @if ($list->thumbnail)
              <img src="{{Config::get('app.thumbnail_url')}}/{{$list->thumbnail}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
              @endif
            </td>
            <td>{{$list->desc}}</td>
            <td>{{$list->created_at}}</td>
            <td>
              @if ($list->status == 1)
              <span class="label label-info">{{$statusEnum[$list->status]}}</span>
              @elseif ($list['status'] == 0)
              <span class="label label-warning">{{$statusEnum[$list->status]}}</span>
              @else
              <span class="label label-default">{{$statusEnum[$list->status]}}</span>
              @endif
            </td>
            <td><a href="/admin/questions?type=sort&id={{$list->id}}" target="_blank">查看</a></td>
            <td>
              <div class="btn-group btn-xs">
                <a class="btn btn-default btn-xs" href="{{url('/admin/sort/'. $list->id .'/edit') }}"><i class="icon-edit"></i> 编辑</a>
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/admin/sort?parent_id='. $list->id) }}"><i class="icon-magic"></i> 内容管理</a></li>
                    <li><a href="{{url('/admin/sort/create?parent_id='. $list->id) }}"><i class="icon-plus-sign"></i> 新建子科目</a></li>
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
    {{ Form::hidden('id', '', array('id' => 'sort_id')) }}
    {{ Form::hidden('status', '', array('id' => 'sort_status')) }}
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
      var sort_id = $this.data("id");
      var sort_status = $this.data("status");
      if (sort_id <= 0) {
          alert("data error");
          return false;
      }
      if (sort_status == '1') {
        status_txt = '发布';
      } else if (sort_status == '-1') {
        status_txt = '下线';
      } else {
        status_txt = '准备';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要设置成' + status_txt + '吗?');
      $("#sort_id").val(sort_id);
      $("#sort_status").val(sort_status);
      $("#myModalForm").attr('action', '{{ url('/admin/sort/') }}/' + sort_id);
      $("#form_method").attr('value', 'PUT');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var sort_id = $this.data("id");
      if (sort_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除吗?');
      $("#sort_id").val(sort_id);
      $("#myModalForm").attr('action', '/admin/sort/'+ sort_id);
      $("#form_method").attr('value', 'DELETE');
      $('#myModal').modal('show');
  });
});
</script>
@stop
