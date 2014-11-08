@extends('Index.master')
@section('title')我的班级@stop

@section('content')
<div class="container-column wrap">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

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
          班级科目 {{Form::select('class_type', $columnall, array(),array('class' => 'tyinput', 'style' => 'padding:5px;width:200px'))}}

          老师 {{ Form::text('teacher_name', '', array('class' => 'tyinput', 'id' => 'inputName', 'style' => 'padding:5px;width:100px'))}}

            {{ Form::hidden('column_id', $query['column_id'], array('class' => '')) }}
            {{ Form::submit('', array('class' => 'submitbtn')) }}
          </td>
        </tr>

      </table>
      {{ Form::close() }}
      <div class="classes-list">
        @if ($classes->count() > 0)
          @foreach ($classes as $list)
          <div class="classse-box" id="classes_{{$list->id}}">
            <div class="classes-txt">
              <div><a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$list->column->id}}"><h2><b>{{$list->name}}</b></h2></a></div>
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
          <div class="clear"></div>
      </div>
  </div>
</div> <!-- /container -->
<div class="clear"></div>
@stop

@section('js')
<script type="text/javascript">
$(function(){
  $(".classse-box").hover(function(){
    $(this).children(".classse-btn").css('display','block');
  }, function(){
    $(this).children(".classse-btn").css('display','none');
  });
  add_class = function(id){
    if(confirm('您确定要加入吗？')){
      $.ajax({
        url:'/classm/doAddClass?class_id='+id,
        // async:false,
        type:'get',
      })
      .fail(function(){
        alert('操作失败');
      })
      .success(function(data){
        // $('#classes_'+id).remove();
        alert(data);
      });
      // alert(htmlobj.responseText);
    }
  };


});
</script>
@stop