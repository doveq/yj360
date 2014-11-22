@extends('Index.master')
@section('title')我的班级 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
        我的班级
        <a href="/classm/add_class?column_id={{$query['column_id']}}" class="tabtool-btn">加入班级</a>
        <a href="/classes/create?column_id={{$query['column_id']}}" class="tabtool-btn">创建班级</a>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @if ($classes->count() == 0)
          <div style="margin:10px;">
            你还未创建任何班级
          </div>
        @else
          @foreach ($classes as $list)
          <div class="classse-box" id="classes_{{$list->id}}" style="background-image:url('{{Attachments::getAvatar($list->teacher->id)}}');">
            <div class="classes-box-name">
              <a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$list->column->id}}">{{$list->name}}</a>
            </div>
            <div class="classes-txt">
              <div>创建人：{{$list->teacher->name}}</div>
              <div>成员：{{$list->students()->where('classmate.status', 1)->count()}}</div>
            </div>
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
                      {{$list->created_at}} {{$list->student->name}} 申请加入班级 {{$list->classes->name}}
                    @endif
                  </td>
                  <td class="tytd" style="color:#999999;">
                      <!-- 学生对应班级状态, 0:待确认, 1: 已同意 2:老师拒绝 3:学生拒绝 -->
                      @if ($list->classmate)
                        @if ($list->classmate->status == 0)
                          @if ($list->type == 2)
                            <a href="javascript:;" onclick="do_status({{$list->classmate_id}},1)">同意</a>
                            <a href="javascript:;" onclick="do_status({{$list->classmate_id}},2)">拒绝</a>
                          @elseif ($list->type == 1)
                            待确认
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
      alert('操作失败');
    })
    .success(function(){
      // alert(update_status);
      // $this.attr('data-status', update_status);
      // $this.text(status_txt)
      location.reload();
    });
  }
$(document).ready(function () {
  // $(".choose_question").on('click',


  $(".btn_publish").on('click', function() {
    var $this = $(this);
    var training_id = $this.data("id");
    var training_status = $this.data("status");
    // var aa = $this.text();
    // alert(training_status);
    if (training_status == 0) {
      status_txt = '撤销发布';
      update_status = 1;
    } else if (training_status == 1) {
      status_txt = '发布';
      update_status = 0;
    }
    $.ajax({
      url:'/training/'+training_id,
      data: {status: update_status},
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
  });
  delete_classes = function(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/classes/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $('#classes_'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  };

  $(".classse-box").hover(function(){
    $(this).children(".classse-btn").css('display','block');
  }, function(){
    $(this).children(".classse-btn").css('display','none');
  });
});
</script>
@stop


