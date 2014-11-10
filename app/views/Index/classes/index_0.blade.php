@extends('Index.master')
@section('title')我的班级 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

  <div class="wrap-right">
      <div class="tabtool">
        <a>我的班级</a>
        @if ($query['column_id'])
          <a style="float:right;" href="/classm/add_class?column_id={{$query['column_id']}}"><img src="/assets/img/addclass.png" /></a>
        @endif
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @if ($classes->count() == 0)
          <div style="margin:10px;">
            你目前还未加入任何班级,可点击"加入班级"加入适合自己的班级
          </div>
        @else
        <div style="margin:20px 10px 10px 10px;">已经加入的班级</div>
          @foreach ($classes as $list)
          <div class="classse-box">
            <div class="classes-txt">
              <div><a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$list->column->id}}"><h2><b>{{$list->name}}</b></h2></a></div>
              <div>创建人：{{$list->teacher->name}} <a href="/message/create?receiver_id={{$list->teacher->id}}&column_id={{$query['column_id']}}" style="background-color:#ffffff;color:#f2664d">给老师私信</a></div>
              <div>成员：{{$list->students()->where('classmate.status', 1)->count()}}</div>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
        @endif

        @if($classmate_logs->count() > 0)
        <div style="margin:20px 10px 10px 10px;">班级申请记录:</div>
        <table class="table-2" border="0" cellpadding="0" cellspacing="0">
            @foreach($classmate_logs as $list)
              <tr>
                  <td class="tytd">
                    @if ($list->type == 1)
                      {{$list->created_at}} {{$list->teacher->name}}(老师) 邀请你加入 {{$list->classes->name}}
                    @elseif ($list->type == 2)
                      {{$list->created_at}} 你申请加入 {{$list->teacher->name}}(老师) 的 {{$list->classes->name}}
                    @endif
                  </td>
                  <td class="tytd">
                      <!-- 学生对应班级状态, 0:待确认, 1: 已同意 2:老师拒绝 3:学生拒绝 -->
                      @if ($list->classmate)
                        @if ($list->classmate->status == 0)
                          @if ($list->type == 1)
                            <a href="javascript:;" onclick="do_status({{$list->classmate_id}},1)">同意</a>
                            <a href="javascript:;" onclick="do_status({{$list->classmate_id}},3)">拒绝</a>
                          @elseif ($list->type == 2)
                            待确认
                          @endif
                        @elseif ($list->classmate->status == 1)
                          已同意
                        @elseif ($list->classmate->status == 2)
                          老师拒绝
                        @elseif ($list->classmate->status == 3)
                          已拒绝
                        @endif
                      @else
                      已失效
                      @endif
                  </td>
              </tr>
              <tr><td colspan="2">
                  <div class="table-2-sp"></div>
              </td></tr>
            @endforeach
        </table>
        @endif

      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
function do_status(classmateid, status)
  {
    $.ajax({
      url:'/classmate/'+classmateid,
      data: {status: status},
      // async:false,
      type:'put',
    })
    .fail(function(){
      alert('操作失败');
    })
    .success(function(){
      // alert(update_status);
      // $this.attr('data-status', update_status);
      // $this.text(status_txt)
      location.reload();
    });
  }
</script>
@stop


