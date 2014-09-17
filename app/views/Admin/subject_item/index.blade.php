@extends('Admin.master_column')
@section('title')浏览科目功能@stop

@section('nav')
  @include('Admin.subject_item.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">科目功能管理</a></li>
      <li class="active">浏览科目功能项</li>
    </ol>
  </div>
  <div class="row text-right">
      <form class="form-inline" role="form">
        <div class="form-group">
          <label class="sr-only" for="inputName">功能名称</label>
          <input type="text" name="name" value="{{$query['name']}}" class="form-control" id="inputName" placeholder="科目名称">
        </div>
        <button type="submit" class="btn btn-info">查找</button>
      </form>
  </div>

  <div class="row text-right">
      {{$paginator->links()}}
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>功能名称</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $subject)
          <tr>
            <td>{{$subject['id']}}</td>
            <td>{{$subject['name']}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="/admin/subject_item/{{$subject['id']}}/edit"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                    <li class="center-block">
                    <form  action="/admin/subject_item/{{$subject['id']}}" method="POST" style="text-align:center">
                      <input type="hidden" value="DELETE" name="_method">
                      <button type="submit" class="btn btn-link btn-xs">删除</button>
                    </form>
                    </li>
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
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form class="form-horizontal" role="form" action="/admin/doUserDel" method="post">
  <input type="hidden" name="id" value="{{$subject['id']}}" />
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">删除用户</h4>
      </div>
      <div class="modal-body">
          确定删除{{$subject['name']}}用户 ？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">确定删除</button>
      </div>
    </div>
    </form>
  </div>
</div>
@stop