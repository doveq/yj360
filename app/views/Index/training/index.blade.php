@extends('Index.master')
@section('title')重点训练 @stop

@section('content')
<div class="container">
  <div><a href="/classes/create">创建班级</a> <a href="/training/create">新建重点训练</a></div>
  <div>
  {{$lists->appends($query)->links()}}
  </div>
  <div>
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
        @foreach ($lists as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td>{{$list->name}}</td>
          <td>{{$list->created_at}}</td>
          <td>{{$list->status}}</td>
          <td>选题 <a href="/training_result?training_id={{$list->id}}">查看练习情况</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div> <!-- /container -->
@stop