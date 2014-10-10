@extends('Admin.master_column')
@section('title')科目内容管理@stop

@section('nav')
  @include('Admin.item_content.nav')
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      <ol class="breadcrumb">
        <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
        <li>{{link_to_route('admin.item_content.index', $subject['name'], array('subject_id' => $subject['id']))}}</li>
        <li class="active">浏览</li>
{{link_to_route('admin.subject_item_relation.edit', '修改功能', array('subject_id' => $subject['id']),array('class' => 'btn btn-primary btn-xs pull-right'))}}
      </ol>
    </div>
    <div class='row'>    </div>

    <div class="row">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>科目功能名称</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td>{{$item['id']}}</td>
              <td><a href="{{ url('/admin/subject_content?subject_id='.$query['subject_id'].'&subject_item_id='.$item->id) }}">{{$item['name']}}</a></td>
              <td>
                <div class="btn-group btn-xs">
                    <a class="btn btn-default btn-xs" href="{{ url('/admin/subject_content?subject_id=' . $subject->id . '&subject_item_id=' . $item['id']) }}"><i class="icon-edit"></i> 内容管理</a>
                    <!-- <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                    <ul class="dropdown-menu">
                      <li><a class="btn_delete" data-toggle="modal" data-id="{{$item['id']}}" data-val="{{$item['name']}}"><i class="icon-trash"></i> 删除</a></li>
                    </ul> -->
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>

  </div>

@stop
