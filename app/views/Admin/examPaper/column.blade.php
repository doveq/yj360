@extends('Admin.master_column')
@section('title')试卷管理@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
    </ol>
  </div>

  <div class="col-md-4 col-md-offset-8 text-right">
      <a href="/admin/examPaper/addColumn?column_id={{$column_id}}" class="btn btn-success">添加试卷</a>
  </div>
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>{{ Form::checkbox('checkAll', 1,false, array('id' => 'checkAll')) }}</th>
            <th>试卷</th>
            <th>描述</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($lists as $list)
              <tr>
                <td>{{ Form::checkbox('question_id[]', $list->id) }} {{$list->id}}</td>
                <td><a href="/admin/examPaper/clist?id={{$list->exam_id}}">{{$list->exam->title}}</a></td>
                <td>{{$list->desc}}</td>
                <td>
                  <a href="javascript:;" class="btn btn-primary btn-xs btn-add" data-id="{{$list->id}}">删除试卷</a>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
  </div>
  <div class="row ">
      <div class="col-md-2">
          <button type="button" class="btn btn-danger btn-addall">批量删除试卷</button>
      </div>
      <div class="text-right">
      </div>
  </div>

@stop

@section('js')
<script type="text/javascript">

$(function(){

  $("#checkAll").click(function() {
      $('input[name="question_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='question_id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='question_id[]']:checked").length ? true : false);
  });

  //批量转移分类
  $(".btn-addall").bind("click", function(){
      $this = $(this);
      var $item = $('input[name="question_id[]"]:checked');
      // alert($item);
      if ($item.length <= 0) {
        alert('请选择题目');
        return;
      }

      var $question_ids = new Array();
      $item.each(function(){
        $question_ids.push($(this).val());
      });

      doAdd($question_ids);

      return false;
  });

  $(".btn-add").click(function(){
      doAdd($(this).data('id'));
      return false;
  });

});

function doAdd(question_ids)
{
    console.log(question_ids);
    $.post("/admin/relation/delColumnExam",
      {
        id: question_ids
      },
      function(data) {
          alert(data.info);
          location.reload();
      },
      "json"
    )
    .fail(function(){
        alert('操作失败，请刷新页面重试');
    });
    return false;
}

</script>
@stop
