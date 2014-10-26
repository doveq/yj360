@extends('Admin.master_column')
@section('title')科目管理@stop


@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
      @if ($query['parent_id'] > 0)
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      @endif
      <li class="active">浏览科目</li>
      @if ($query['parent_id'] > 0)
      <a href="{{url('/admin/column?parent_id='.$parent->parent_id)}}"><span class='pull-right  icon-arrow-up'> 返回上级</span></a>
      @endif
    </ol>
  </div>

  <div class="row">
      <div class="col-md-4 col-md-offset-8 text-right">
        <a href="/admin/topic/column?id={{$query['parent_id']}}" class="btn btn-success">添加内容</a>
      </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>{{Form::checkbox('checkAll', 1,false, array('id' => 'checkAll'))}}</th>
            <th>#</th>
            <th>题干</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
            @foreach($list as $v)
            <tr>
                <td><label>{{ Form::checkbox('id[]', $v['question_id']) }}</label></td>
                <td>{{$v['question_id']}}</td>
                <td><a href="/topic?id={{$v->question['id']}}" target="_blank">{{$v->question['txt']}}</a></td>
                <td><a href="javascript:;" class="btn btn-primary btn-xs btn-del" data-id="{{$v['question_id']}}">删除</a></td>
            </tr>
            @endforeach
        </tbody>
      </table>

      <div class="col-md-2">
          <button type="button" class="btn btn-danger btn-delall">批量删除</button>
      </div>
      <div class="col-md-10 text-right">
        {{$list->appends($query)->links()}}
      </div>
  </div>

@stop

@section('js')
<script type="text/javascript">
var column_id = {{$query['parent_id']}};

$(function(){

  $("#checkAll").click(function() {
      $('input[name="id[]"]').prop("checked",this.checked);
  });

  $subBox = $("input[name='id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='id[]']:checked").length ? true : false);
  });

  //删除
  $(".btn-delall").bind("click", function(){

    var $item = $('input[name="id[]"]:checked');
    // alert($item);
    if ($item.length <= 0) {
      alert('请选择题目');
      return;
    }

    var $question_ids = new Array();
    $item.each(function(){
      $question_ids.push($(this).val());
    });
    
    del($question_ids);

    return false;

  });

  $(".btn-del").bind("click", function(){
      del($(this).data('id'));
      return false;
  });

  function del(id)
  {
      if(confirm('您确定要删除吗？')){
      $.post("/admin/relation/del_question",
        {
          question_id: id,
          column_id: column_id
        },
        function(data) {
            if(data.status == 1)
            {
                alert(data.info);
                location.reload();
            }
            else
                alert(data.info);
        },
        "json"
      )
      .fail(function(){
          console.log(data);
          alert("删除失败,请刷新页面重试");
      });
    }
  }
});
</script>
@stop
