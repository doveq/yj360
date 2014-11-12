@extends('Index.master')
@section('title')我的班级@stop

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
          <a href="/classm/add_class?column_id={{$query['column_id']}}"><img src="/assets/img/addclass.png" /></a>
          <a href="/message?column_id={{$query['column_id']}}" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>
      {{ Form::open(array('url' => '/classm/add_class?column_id='.$query['column_id'], 'method' => 'post')) }}
      <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #f1f1f1; width:100%;">
        <tr><td style="background-color:#00bbac;padding:10px;">搜索加入</td></tr>

        <tr>
          <td style="width:20%;text-align:center;">
          老师 {{ Form::text('teacher_name', '', array('class' => 'tyinput', 'id' => 'inputName', 'style' => 'padding:5px;width:100px'))}}

            {{ Form::hidden('column_id', $query['column_id'], array('class' => '')) }}
            {{ Form::submit('搜索', array('class' => 'btnsubmit')) }}
          </td>
        </tr>

      </table>
      {{ Form::close() }}
      <div class="classes-list">
        @if (isset($classes))
          @if ($classes->count() > 0)
            @foreach ($classes as $list)
            <div class="classse-box" id="classes_{{$list->id}}">
              <div class="classes-txt">
                <div><h2><b>{{$list->name}}</b></h2></div>
                <div>创建人：{{$list->teacher->name}}</div>
                <div>成员：{{$list->students->count()}}</div>
              </div>
              <div class="classse-btn" style="display:none;margin-top:-30px;">
                  <a class="addclass" style="width:200px;text-align:center;" href="javascript:;" onClick="add_class('{{$list->id}}');" >加入班级</a>
                  <div class="clear"></div>
              </div>
            </div>
            @endforeach
          @endif
        @else
        未找到班级
        @endif
          <div class="clear"></div>
      </div>
  </div>
</div> <!-- /container -->
<div class="clear"></div>
</div>
@stop

@section('js')
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">
$(function(){
  $(".classse-box").hover(function(){
    $(this).children(".classse-btn").css('display','block');
  }, function(){
    $(this).children(".classse-btn").css('display','none');
  });
  add_class = function(id){
    layer.confirm('您确定要加入吗？', function(){
        $.ajax({
          url:'/classm/doAddClass?class_id='+id,
          type:'get',
        })
        .fail(function(){
          layer.msg('添加失败', 2, 1);
        })
        .success(function(data){
          if (data == 1) {
            layer.msg('已经提交申请，请等待老师审核！', 2, 1,function(){
              window.location.href='/classes?column_id={{$query['column_id']}}';
            });
          } else if (data == 2) {
            layer.msg('你已经加入过此班级', 2, 5);
          } else if (data == 3) {
            layer.msg('加入失败,一个科目下只能加入两个班级', 2, 3);
          }
        });
    });
  };


});
</script>
@stop