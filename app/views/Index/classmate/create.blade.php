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
          <a href="/classmate/create?class_id={{$classes->id}}&column_id={{$query['column_id']}}"><img src="/assets/img/classes-tj.jpg" /></a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div>
          {{ Form::open(array('url' => '/classmate?column_id='.$query['column_id'], 'method' => 'post')) }}

        <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>{{ Form::checkbox('checkAll', 1, false, array('id' => 'checkAll')) }}</th>
              <th>ID</th>
              <th>姓名</th>
              <th>性别</th>
              <th>电话</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($students as $list)
        <tr class="text-center">
          <td>
            {{ Form::checkbox('student_id[]', $list->id, false, array('id' => 'userid'.$list->id)) }}
          </td>
          <td>
            {{ Form::label('userid'.$list->id, $list->id, array('class' => '')) }}
          </td>
          <td>
            {{ Form::label('userid'.$list->id, $list->name, array('class' => '')) }}
          </td>
          <td>{{ $genderEnum[$list->gender] }}</td>
          <td>{{ $list->tel }}</td>
        </tr>
        @endforeach
        <tr>
          <td>
          </td>
          <td>
            {{ Form::hidden('class_id', $classes->id, array('id' => 'class_id')) }}
            {{ Form::button('', array('class' => 'submitbtn', 'type' =>'submit')) }}
          </td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr><td colspan='5'>{{$students->appends(Input::all())->links()}}</td></tr>
          </tbody>
        </table>
  {{ Form::close() }}


      </div>
  </div>
</div> <!-- /container -->
<div class="clear"></div>
@stop

@section('js')
<script type="text/javascript">
$(function(){

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