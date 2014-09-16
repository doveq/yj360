@extends('Admin.master_column')
@section('title')浏览科目@stop

@section('nav')
  @include('Admin.subject_nav')
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
          <label class="sr-only" for="inputOnlineat">科目描述</label>
          <input type="text" name="online_at" value="{{$query['online_at']}}" class="form-control" id="inputOnlineat" placeholder="上线时间">
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

        <button type="submit" class="btn btn-success">查找</button>
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
            <td>{{$subject['desc']}}</td>
            <td>{{$subject['online_at']}}</td>
            <td>{{$statusEnum[$subject['status']]}}</td>
            <td><a href="/admin/userEdit/{{$subject['id']}}" class="btn btn-primary btn-xs">编辑</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$paginator->links()}}
  </div>
</div>
</div>
@stop