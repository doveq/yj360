@extends('Index.master')
@section('title')我的班级@stop

@section('content')
<div class="container-column wrap">
  <div class="wrap-left">
      <div class="sort">
          <div class="sort-tit">全部分类</div>
          <div class="sort-bb"></div>
          <ul class="sort-list">
            @foreach($columns as $k => $column)
            <li><a href="/column?id={{$column->id}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj sort-wbj-act"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd"><a href="#">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

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
        <!--
        <tr>
          <td style="width:20%;text-align:right;">
          
          班级类别 {{ Form::select('class_type', array('3' => '初级'), '', array('class' => 'tyinput', 'id' => 'inputClassid','style' => 'width:200px')) }}
         
          {{ Form::text('teacher_name', '', array('class' => 'tyinput', 'id' => 'inputName', 'style' => 'width:200px'))}}

            {{ Form::hidden('column_id', $query['column_id'], array('class' => '')) }}
            {{ Form::submit('', array('class' => 'submitbtn')) }}
          </td>
        </tr>
        -->
      </table>
      {{ Form::close() }}
      <div class="classes-list">
        @if (isset($classes))
          @foreach ($classes as $list)
          <div class="classse-box" id="classes_{{$list->id}}">
            <div class="classes-txt">
              <div><a style="color:#ffffff" href="/classes/{{$list->id}}?column_id={{$query['column_id']}}"><h2><b>{{$list->name}}</b></h2></a></div>
              <div>创建人：{{$list->teacher->name}}</div>
              <div>成员：{{$list->students->count()}}</div>
            </div>
            <div class="classse-btn" style="display:none;margin-top:-30px;">
                <!--
                <a href="/classes/{{$list->id}}?column_id={{$query['column_id']}}">班级成员</a>
                -->
                <a class="delclass" style="width:200px;text-align:center;" href="#" >加入班级</a>
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
  $("#checkAll").click(function() {
      $('input[name="student_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='student_id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='student_id[]']:checked").length ? true : false);
  });

});
</script>
@stop