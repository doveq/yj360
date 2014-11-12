@extends('Admin.master_column')
@section('title')试卷管理@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/examPaper">试卷管理</a></li>
        <li>{{$info->title}}</li>
    </ol>
  </div>

  <div class="row">
      <div class="col-md-4 col-md-offset-8 text-right">
          <a href="/admin/examPaper/child?parent_id={{$info->id}}" class="btn btn-success">添加大题</a>
      </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>大题题干</th>
            <th>题量</th>
            <th>每题分数</th>
            <th>出题数</th>
            <th>排序序号</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($lists as $list)
              <tr>
                <td>{{$list->id}}</td>
                <td><a href="/admin/examPaper/qlist?id={{$list->id}}">{{$list->title}}</a></td>
                <td>{{$list->count}}</td>
                <td>{{$list->score}}</td>
                <td>{{$list->rnum}}</td>
                <td>{{$list->ordern}}</td>
                <td>
                    <div class="btn-group btn-xs">
                      <a class="btn btn-default btn-xs" href="{{url('/admin/examPaper/child/edit?id='. $list->id) }}"><i class="icon-edit"></i> 编辑</a>
                      <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                      <ul class="dropdown-menu">
                          <li class="divider"></li>
                          <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$list->id}}" ><i class="icon-trash"></i> 删除</a></li>
                      </ul>
                    </div>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      
  </div>
@stop

@section('js')
<script type="text/javascript">

$(function(){

  //删除
  $(".btn_delete").bind("click", function(){
      if (confirm("确认删除吗？"))
      {
          id = $(this).data('id');
          $.post("/admin/examPaper/del", {"ajax": 1, "id": id},

          function(data) {
              if(data == 1)
              {
                  location.reload();
                  alert("删除成功");
              }
              else
              {
                  alert("删除失败,请刷新页面重试");
              }
          },
          "json"
        )
        .fail(function(){
            console.log(data);
            alert("删除失败,请刷新页面重试");
        });
      }
  });

});
</script>
@stop
