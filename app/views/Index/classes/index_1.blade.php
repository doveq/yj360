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
            <li><a href="/column?id={{$column->id}}&column_id={{$query['column_id']}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj sort-wbj-act"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd"><a href="/products?column_id={{$query['column_id']}}">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

  <div class="wrap-right">
      <div class="tabtool">
          <a href="/classes/create?column_id={{$query['column_id']}}"><img src="/assets/img/addclasses.jpg" /></a>
          <a href="/training/create?column_id={{$query['column_id']}}"><img src="/assets/img/addzdxl.jpg" /></a>
          <a href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          @foreach ($classes as $list)
          <div class="classse-box" id="classes_{{$list->id}}">
            <div class="classes-txt">
              <div><a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$query['column_id']}}"><h2><b>{{$list->name}}</b></h2></a></div>
              <div>创建人：{{$list->teacher->name}}</div>
              <div>成员：{{$list->students->count()}}</div>
            </div>
            <div class="classse-btn" style="display:none;margin-top:-30px;">
                <a href="/classes/{{$list->id}}?column_id={{$query['column_id']}}">班级成员</a>
                <a class="delclass" href="javascript:;" onClick="delete_classes('{{$list->id}}');">删除班级</a>
                <div class="clear"></div>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
      </div>

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
            @foreach ($trainings as $list)
            <tr>
              <td>{{$list->id}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->created_at}}</td>
              <td>
                <button class="btn_publish" data-id="{{$list->id}}" data-status="{{$list->status}}">{{$statusEnum[$list->status]}}</button>
              </td>
              <td><a href="javascript:void(0);" class="choose_question">选题</a> <a href="/training_result?training_id={{$list->id}}&column_id={{$query['column_id']}}">查看练习情况</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  $(".choose_question").on('click', function(){
    $.layer({
        type: 1,
        title: false, //不显示默认标题栏
        shade: [0], //不显示遮罩
        area: ['400px', '300px'],
        page: {html: '请选择题库:<br/>原创题库 我的收藏'}
    });
  });

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


