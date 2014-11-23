@extends('Index.master')
@section('title')我的班级 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title">我的班级</span>
        <span class="tab-btn">
          <a href="/classes/create?column_id={{$query['column_id']}}" class="tabtool-btn">创建班级</a>
          <a href="/classm/add_class?column_id={{$query['column_id']}}" class="tabtool-btn">加入班级</a>
        </span>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @if (count($classes) == 0)
          <div style="margin:10px;">
            你还未创建或加入任何班级
          </div>
        @else
          @foreach ($classes as $list)
          <div class="classse-box" id="classes_{{$list->id}}" style="">
            <a href="/classes/{{$list->id}}?column_id={{$list->column->id}}">
            <div class="classes-box-head" style="background-image:url('{{Attachments::getAvatar($list->teacher->id)}}'); ">
            </div>
            <div class="classes-box-name">
              {{$list->name}}
            </div>
            <div class="classes-txt">
              <div>创建者：{{$list->teacher->name}} @if ($list->teacher->id == Session::get('uid'))(我)@endif</div>
              <div>成员：{{$list->students()->where('classmate.status', 1)->count()}}</div>
            </div>
            </a>
            @if ($list->teacher->id == Session::get('uid'))
            <div class="classse-btn">
                <a class="delclass" href="javascript:;" onClick="delete_classes('{{$list->id}}');">删除</a>
            </div>
            @endif

          </div>
          @endforeach
          <div class="clear"></div>
        @endif

        @if($classmate_logs->count() > 0)
        <div style="margin:20px 10px 0px 0px;font-size:18px;color:#499528;border-bottom: 1px solid #ccc;">班级申请加入消息</div>
        <table class="table-2" border="0" cellpadding="0" cellspacing="0">
            @foreach($classmate_logs as $list)
              <tr>
                  <td class="tytd" style="color:#999999;">
                    @if ($list->type == 1)
                      {{$list->created_at}} 你邀请 {{$list->student->name}} 加入 {{$list->classes->name}}
                    @elseif ($list->type == 2)
                      {{$list->created_at}} {{$list->student->name}} 申请加入{{$list->teacher->name}} 的 {{$list->classes->name}}
                    @endif
                  </td>
                  <td class="tytd" style="color:#999999;">
                      <!-- 学生对应班级状态, 0:待确认, 1: 已同意 2:老师拒绝 3:学生拒绝 -->
                      @if ($list->classmate)
                        @if ($list->classmate->status == 0)
                          @if ($list->type == 2 && $list->teacher_id == Session::get('uid'))
                            <a href="javascript:;" onclick="do_status({{$list->classmate_id}},1)">同意</a>
                            <a href="javascript:;" onclick="do_status({{$list->classmate_id}},2)">拒绝</a>
                          @else
                            待确认 <a href="javascript:;" onclick="cancel_sq({{$list->classmate_id}})">撤销申请</a>

                          @endif
                        @elseif ($list->classmate->status == 1)
                          已同意
                        @elseif ($list->classmate->status == 2)
                          已拒绝
                        @elseif ($list->classmate->status == 3)
                          学生拒绝
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
          <tr><td colspan="2" style="text-align:center;">
            {{$classmate_logs->appends($query)->links()}}
          </td></tr>
        </table>
        @endif


      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

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
      layer.msg('删除失败', 2, 1);
    })
    .success(function(){
      location.reload();
    });
  }
$(document).ready(function () {
  delete_classes = function(id){
    layer.confirm('您确定要删除吗？', function(){
      $.ajax({
        url:'/classes/'+id+'?column_id='+{{$query['column_id']}},
        // async:false,
        type:'delete',
      })
      .fail(function(){
        layer.msg('删除失败', 2, 1);
      })
      .success(function(data){
        if (data == 'ok') {
          layer.closeAll();
          $('#classes_'+id).remove();
        } else {
          layer.msg('删除失败,班级中还有成员', 2, 5);
        }
      });
    });
  };


  cancel_sq = function(id){
    layer.confirm('您确定要撤销吗？', function(){
      $.ajax({
        url:'/classmate/postDelete?id='+id+'&column_id='+{{$query['column_id']}},
        // async:false,
        type:'post',
      })
      .fail(function(){
        layer.msg('删除失败', 2, 1);
      })
      .success(function(data){
          layer.closeAll();
          location.reload();
      });
    });
  };

  $(".classse-box").hover(function(){
    $(this).children(".classse-btn").css('display','block');
  }, function(){
    $(this).children(".classse-btn").css('display','none');
  });
});
</script>
@stop


