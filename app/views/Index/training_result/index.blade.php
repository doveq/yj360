@extends('Index.master')
@section('title')重点训练@stop

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
          <div class="sort-item sort-wbj sort-wbj-act"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd"><a href="#">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

  <div class="wrap-right">
      <div class="tabtool">
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div>
        <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            @foreach ($lists as $user_id => $list)
        <tr>
          <td>{{$list['name']}}</td>
          <td><a href="/message/create?receiver_id={{$user_id}}">私信TA</a></td>
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
  </div>
</div> <!-- /container -->
<div class="clear"></div>
@stop

@section('js')
<script type="text/javascript">
</script>
@stop