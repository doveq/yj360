@extends('Admin.master_column')
@section('title')试卷管理@stop


@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/examPaper/clist?id={{$parent->id}}">{{$parent->title}}</a></li>
      <li class="active">{{$info->title}}</li>
    </ol>
  </div>

  <div class="row">
      <div class="col-md-4 col-md-offset-8 text-right">
        <a href="/admin/topic/exam?id={{$info->id}}" class="btn btn-success">添加题目</a>
      </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>{{Form::checkbox('checkAll', 1,false, array('id' => 'checkAll'))}}</th>
            <th>#</th>
            <th>题干</th>
            <th>排序序号</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
            @foreach($list as $v)
            <tr>
                <td><label>{{ Form::checkbox('id[]', $v['question_id']) }}</label></td>
                <td>{{$v['question_id']}}</td>
                <td><a href="/topic?id={{$v->question['id']}}&is_exam={{$v['exam_id']}}" target="_blank">{{$v->question['txt']}}</a></td>
                <td>{{$v['ordern']}}</td>
                <td>
                  <a href="javascript:;" class="btn btn-primary btn-xs showedit" data-toggle="modal" data-id="{{$v['id']}}" data-tit="{{$v->question['txt']}}" data-ordern="{{$v['ordern']}}">编辑</a>
                  &nbsp;&nbsp;
                  <a href="javascript:;" class="btn btn-danger btn-xs btn-del" data-id="{{$v['question_id']}}">删除</a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>

      <div class="col-md-2">
          <button type="button" class="btn btn-danger btn-delall">批量删除</button>
      </div>
  </div>


<div class="modal fade" id="myModal">
  <form method="POST" action="/admin/examPaper/doEditQuestion" role="form">
  <input type="hidden" id="dfrom" name="from" value="" />
  <input type="hidden" id="did" name="id" value="" />

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">编辑排序序号</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label" >题目</label>
          <div id="dtit"></div>
        </div>
        <div class="form-group">
          <label class="control-label" >排序序号</label>
          <div>
            <input class="form-control" type="text" value="0" name="ordern" id="dordern" />
            <p class="help-block">序号越小,排序越靠前</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <input type="submit" value="保存" class="btn btn-primary" />
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div><!-- /.modal -->

@stop

@section('js')
<script type="text/javascript">
var exam_id = {{$info->id}};

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
      $.post("/admin/relation/delExam",
        {
          question_id: id,
          id: exam_id
        },
        function(data) {
            if(data.status == 1)
            {
                location.reload();
                alert(data.info);
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

  $(".showedit").on("click", function(){
      $('#did').val( $(this).data('id') );
      $('#dtit').html( $(this).data('tit') );
      $('#dordern').val( $(this).data('ordern') );
      $('#dfrom').val(location.href);

      $('#myModal').modal();
  });

});
</script>
@stop
