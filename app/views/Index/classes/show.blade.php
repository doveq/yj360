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
          <a href="javascript:void(0);" onClick="delete_all();"><img src="/assets/img/classes-sc.jpg" /></a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div>
        <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>{{ Form::checkbox('checkAll', 1, false, array('id' => 'checkAll')) }}</th>
              <th>姓名</th>
              <th>性别</th>
              <th>电话</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($classes->students as $list)
            <tr id="{{$list->pivot->id}}">
              <td>{{Form::checkbox('classmate_id[]', $list->pivot->id)}}</td>
              <td>{{$list->name}}</td>
              <td>{{$genderEnum[$list->gender]}}</td>
              <td>{{$list->tel}}</td>
              <td><a href="/message/create?receiver_id={{$list->id}}&column_id={{$query['column_id']}}">私信</a> <a href="javascript:void(0);" onClick="delete_classmate('{{$list->pivot->id}}');">删除</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>


      </div>
  </div>
</div> <!-- /container -->
<div class="clear"></div>
@stop

@section('js')
<script type="text/javascript">

  function delete_classmate(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/classmate/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $('#'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  }

  function delete_all(){
    $this = $(this);
    var $item = $('input[name="classmate_id[]"]:checked');
    // alert($item);
    if ($item.length <= 0) {
      alert('请选择学生');
      return false;
    }
    if (confirm('你确定要批量删除吗?')){
      var $classmate_ids = new Array();
      $item.each(function(){
        $classmate_ids.push($(this).val());
      });
      $.ajax({
        url:'/classmate/postDelete',
        data: {id: $classmate_ids},
        type:'post',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $.each($classmate_ids, function(index,value){
          $('#'+value).remove();
        });

      });
    }
  }

  $("#checkAll").click(function() {
      $('input[name="classmate_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='classmate_id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='classmate_id[]']:checked").length ? true : false);
  });

</script>
@stop