@extends('Index.master')
@section('title')重点训练 @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        我的作业
        <a style="float:right;" href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
        <a href="/training/create?column_id={{$query['column_id']}}" class="tabtool-btn">布置作业</a>
      </div>
      <div class="clear"></div>
        <table  class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>序号</th>
              <th>训练名称</th>
              <th>时间</th>
              <th>状态操作</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lists as $list)
            <tr>
              <td>{{$list->id}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->created_at}}</td>
              <td>
                <button class="btn_publish" data-id="{{$list->id}}" data-status="{{$list->status}}">{{$statusEnum[$list->status]}}</button>
              </td>
              <td><a href="javascript:void(0);" onclick="choose_question({{$list->id}})">选题</a> <a href="/training_result?training_id={{$list->id}}&column_id={{$query['column_id']}}">查看练习情况</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
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
      iframe: {src: "/favorite/choose?column_id={{$query['column_id']}}&training_id="+training_id}
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

});
</script>
@stop


