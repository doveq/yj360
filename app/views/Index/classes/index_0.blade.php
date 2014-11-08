@extends('Index.master')
@section('title')我的班级 @stop

@section('content')
<div class="container-column wrap">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

  <div class="wrap-right">
      <div class="tabtool">
        <a>你已经加入的班级</a>
        @if ($query['column_id'])
          <a style="float:right;" href="/classm/add_class?column_id={{$query['column_id']}}"><img src="/assets/img/addclass.png" /></a>
        @endif
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @if ($classes->count() == 0)
        你目前还未加入任何班级,可点击"加入班级"加入适合自己的班级
        @else
          @foreach ($classes as $list)
          <div class="classse-box">
            <div class="classes-txt">
              <div><a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$list->column->id}}"><h2><b>{{$list->name}}</b></h2></a></div>
              <div>创建人：{{$list->teacher->name}} <a href="/message/create?receiver_id={{$list->teacher->id}}&column_id={{$query['column_id']}}" style="background-color:#ffffff;color:#f2664d">给老师私信</a></div>
              <div>成员：{{$list->students->count()}}</div>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
        @endif
      </div>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
</script>
@stop


