@extends('Index.master')
@section('title')我的班级@stop

@section('content')
<div class="container">
  <div><a href="/classmate/create?class_id={{$classes->id}}">添加成员</a> <a href="#">批量删除</a></div>
  <div>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>姓名</th>
          <th>性别</th>
          <th>电话</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classes->students as $list)
        <tr>
          <td></td>
          <td>{{$list->name}}</td>
          <td>{{$list->gender}}</td>
          <td>{{$list->tel}}</td>
          <td>私信 删除</td>
        </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div> <!-- /container -->
@stop