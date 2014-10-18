@extends('Index.master')
@section('title')我的消息 @stop

@section('content')
<div class="container">
  <div>
  {{$lists->appends($query)->links()}}
  </div>
  <div>
    <table>
      <thead>
        <tr>
          <th>序号</th>
          <th>消息内容</th>
          <th>发送时间</th>
          <th>发送人</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($lists as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td>{{$list->content}}</td>
          <td>{{$list->created_at}}</td>
          <td>{{$list->sender->name}}</td>
          <td><a href="/message/{{$list->id}}">查看</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div> <!-- /container -->
@stop