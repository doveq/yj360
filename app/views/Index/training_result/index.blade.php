@extends('Index.master')
@section('title')查看练习情况 @stop

@section('content')
<div class="container">
  <div><a href="/training">返回</a></div>

  <div>
    <table>
      <!-- <thead>
        <tr>
          <th>序号</th>
          <th>训练名称</th>
          <th>时间</th>
          <th>状态操作</th>
          <th>操作</th>
        </tr>
      </thead> -->
      <tbody>
        @foreach ($lists as $user_id => $list)
        <tr>
          <td>{{$list['name']}}</td>
          <td>私信TA</td>
          <td>
            @if (isset($list[1]))
            正确
            {{count($list[1])}}
            @endif
            @if (isset($list[0]))
             错误{{count($list[0])}}
            @endif
           </td>
          <td>
            @if (isset($list[0]))
            错题是:
            @foreach ($list[0] as $n)
            第{{$n}}题
            @endforeach
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div> <!-- /container -->
@stop