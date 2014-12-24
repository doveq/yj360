@extends('Index.master')
@section('title')我的班级@stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title-prev">
            <a href="/classes?column_id={{$query['column_id']}}" class="tabtool-btn-back">我的班级</a>
            <span style="color:#c9c9c9;">&nbsp;>&nbsp;</span>
        </span>
        <span class="tab-title">加入班级</span>
      </div>
      <div class="clear"></div>
      {{ Form::open(array('url' => '/classm/add_class?column_id='.$query['column_id'], 'method' => 'post')) }}
      <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #f1f1f1; width:100%;">
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
            <div class="classse-box index" id="classes_{{$list->id}}" style="height:205px;">
              <div class="classes-box-head index" style="background-image:url('{{Attachments::getAvatar($list->teacher->id)}}'); ">
              </div>
              <div class="classes-box-name index">
                {{$list->name}}
              </div>
              <div class="classes-txt index" style="bottom:0;">
                <div>老师：{{$list->teacher->name}} @if($list->teacher->id == Session::get('uid'))(我)@endif</div>
                <div>成员：{{$list->students()->where('classmate.status', 1)->count()}}</div>
              </div>
              @if ($list->teacher->id != Session::get('uid'))
              <div class="classse-btn">
                <a class="addclass" href="javascript:;" onClick="add_class('{{$list->id}}');">加入班级</a>
              </div>
              @endif
            </div>
            @endforeach
          @endif
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
            layer.msg('加入失败,当前科目下你已经申请或者加入过一个班级', 2, 3);
          }
        });
    });
  };


});
</script>
@stop