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
        <a>已创建班级</a>
          <a href="/classes/create?column_id={{$query['column_id']}}"><img src="/assets/img/addclasses.jpg" /></a>
          <a style="float:right;" href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        @if ($classes->count() == 0)
          <div style="margin:10px;">
            你还未创建任何班级
          </div>
        @else
          @foreach ($classes as $list)
          <div class="classse-box" id="classes_{{$list->id}}">
            <div class="classes-txt">
              <div><a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$list->column->id}}"><h2><b>{{$list->name}}</b></h2></a></div>
              <div>创建人：{{$list->teacher->name}}</div>
              <div>成员：{{$list->students->count()}}</div>
            </div>
            <div class="classse-btn" style="display:none;margin-top:-30px;">
                <a href="/classes/{{$list->id}}?column_id={{$list->column->id}}">班级成员</a>
                <a class="delclass" href="javascript:;" onClick="delete_classes('{{$list->id}}');">删除班级</a>
                <div class="clear"></div>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
        @endif

        @if(!empty($messages))
        <div style="margin:20px 10px 10px 10px;">班级申请记录:</div>
        <table class="table-2" border="0" cellpadding="0" cellspacing="0">
            @foreach($messages as $list)
              <tr>
                  <td class="tytd">
                    {{$list->content}}
                  </td>
                  <td class="tytd table-2-del">
                    @if ($list->classmate->status == 1)
                    确认
                    @elseif ($list->classmate->status == 2)
                    待确认
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
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">
  function choose_fav(training_id)
  {
    layer.closeAll();
    $.layer({
      type: 2,
      border: [0],
      title: false,
      shadeClose: true,
      // closeBtn: false,
      area: ['860px', '600px'],
      // offset: [($(window).height() - 100)/2+'px', ''], //上下垂直居中
      iframe: {src: '/favorite/choose?training_id='+training_id}
    });
  }
  function choose_question(training_id){
    $.layer({
        type: 1,
        title: false, //不显示默认标题栏
        shade: [1], //不显示遮罩
        shadeClose: true,
        area: ['auto', 'auto'],
        // offset: [($(window).height() - 700)/2+'px', ''], //上下垂直居中
        page: {
          html: '<div style="margin:10px 20px 20px; width:400px;">请选择题库:</div><div style="margin:20px;text-align:center"><a href="javascript:void(0);" onclick="choose_fav('+training_id+');">我的收藏</a></div>'
        }
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


