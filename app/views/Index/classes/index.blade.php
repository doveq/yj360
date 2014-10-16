@extends('Index.master')
@section('title')我的班级@stop

@section('content')
<div class="container">
  <div><a href="/classes/create">创建班级</a> <a href="/training/create">新建重点训练</a> 消息({{Session::get('newmassage_count')}})</div>
  <div>
    <table>
      <thead>
        <tr>
          <th>序号</th>
          <th>班级名称</th>
          <th>创建人</th>
          <th>成员</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classes as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td><a href="classes/{{$list->id}}">{{$list->name}}</a></td>
          <td>{{$list->teacher->name}}</td>
          <td>{{$list->students->count()}}</td>
          <td></td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <table>
      <thead>
        <tr>
          <th>序号</th>
          <th>训练名称</th>
          <th>时间</th>
          <th>状态操作</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($trainings as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td>{{$list->name}}</td>
          <td>{{$list->created_at}}</td>
          <td>{{$list->status}}</td>
          <td>选题 查看练习情况</td>
        </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div> <!-- /container -->
@stop