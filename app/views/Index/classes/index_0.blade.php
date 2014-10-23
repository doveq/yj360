@extends('Index.master')
@section('title')我的班级 @stop

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
          <a href="/classm/add_class?column_id={{$query['column_id']}}"><img src="/assets/img/addclass.png" /></a>
          <a href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @if ($classes->count() == 0)
        你目前还未加入任何班级,可点击"加入班级"加入适合自己的班级
        @endif
          @foreach ($classes as $list)
          <div class="classse-box">
            <div class="classes-txt">
              <div><h2><b>{{$list->name}}</b></h2></div>
              <div>创建人：{{$list->teacher->name}} <a href="/message/create?receiver_id={{$list->teacher->id}}&column_id={{$query['column_id']}}" style="background-color:#ffffff;color:#f2664d">给老师私信</a></div>
              <div>成员：{{$list->students->count()}}</div>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
      </div>
      @if ($classes->count() != 0)
      <table  class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>序号</th>
              <th>训练名称</th>
              <th>时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($classes as $list)
            @foreach ($list->trainings as $li)
            <tr>
              <td>{{$li->id}}</td>
              <td>{{$li->name}}</td>
              <td>{{$li->created_at}}</td>
              <td><a href="/topic?training_id={{$li->id}}&column_id={{$query['column_id']}}">开始练习</a></td>
            </tr>
            @endforeach
            @endforeach
          </tbody>
        </table>
      @endif
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
</script>
@stop


