@extends('Index.master')
@section('title')我的消息 @stop

@section('content')
<div class="container-column wrap">
  <div class="wrap-left">
      <div class="sort">
          <div class="sort-tit">全部分类</div>
          <div class="sort-bb"></div>
          <ul class="sort-list">
            @foreach($columns as $k => $column)
            <li><a href="/column?id={{$column->id}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd"><a href="#">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

  <div class="wrap-right">
      <div class="tabtool">
          <a href="/message" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          <table class="stable" border="0" cellpadding="0" cellspacing="0">
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
          @if ($list->status == 0)
          <tr style="font-weight:bold">
          @else
          <tr>
          @endif
            <td>{{$list->id}}</td>
            <td>{{str_limit($list->content, 10, '...')}}</td>
            <td>{{$list->created_at}}</td>
            <td>{{$list->sender->name}}</td>
            <td><a href="/message/{{$list->id}}">查看</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
</script>
@stop


