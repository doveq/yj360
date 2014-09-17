@extends('Admin.master_column')
@section('title')浏览科目@stop

@section('nav')
  @include('Admin.subject.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">科目管理</a></li>
      <li class="active">浏览科目</li>
    </ol>
  </div>
  <div class="row text-right">
      <form class="form-inline" role="form">
        <div class="form-group">
          <label class="sr-only" for="inputName">科目名称</label>
          <input type="text" name="name" value="{{$query['name']}}" class="form-control" id="inputName" placeholder="科目名称">
        </div>

        <div class="form-group">
          <label class="sr-only" for="inputDesc">科目描述</label>
          <input type="text" name="desc" value="{{$query['desc']}}" class="form-control" id="inputDesc" placeholder="科目描述">
        </div>

        <div class="form-group">
          <label class="sr-only" for="inputStatus">状态</label>
          <select class="form-control" name="status" id="inputStatus">
              <option value="" >所有状态</option>
              @foreach ($statusEnum as $v => $n)
                  <option value="{{$v}}" @if( is_numeric($query['status']) && $v == $query['status']) selected="selected" @endif >{{$n}}</option>
              @endforeach
          </select>
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
            <th>科目名称</th>
            <th>科目描述</th>
            <th>上线时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $subject)
          <tr>
            <td>{{$subject['id']}}</td>
            <td>{{$subject['name']}}</td>
            <td>{{$subject['description']}}</td>
            <td>{{$subject['online_at']}}</td>
            <td>{{$statusEnum[$subject['status']]}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="/admin/subject/{{$subject['id']}}/edit"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#"><i class="icon-asterisk"></i> 功能管理</a></li>
                      <li><a href="#"><i class="icon-magic"></i> 内容管理</a></li>
                      <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#chgModal">确认</button> -->
                      <li class="divider"></li>
                      <li>
                        <form  action="/admin/subject/{{$subject['id']}}" method="POST" style="padding: 3px 20px;">
                          <input type="hidden" value="PUT" name="_method">
                          <input type="hidden" value="1" name="status">
                          <button type="submit" class="btn btn-link btn-xs"><i class="icon-ok"></i> 发布</button>
                        </form>
                      </li>
                      <li>
                        <form  action="/admin/subject/{{$subject['id']}}" method="POST" style="padding: 3px 20px;">
                          <input type="hidden" value="PUT" name="_method">
                          <input type="hidden" value="-1" name="status">
                          <button type="submit" class="btn btn-link btn-xs"><i class="icon-trash"></i> 下线</button>
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
<div class="modal fade" id="chgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form class="form-horizontal" role="form" action="/admin/subject" method="post">
  <input type="hidden" name="id" value="" id="chg_id"/>
  <input type="hidden" name="status" value="" id="chg_status"/>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">确认</h4>
      </div>
      <div class="modal-body">
          确认执行此操作吗?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">确定</button>
      </div>
    </div>
    </form>
  </div>
</div>
@stop