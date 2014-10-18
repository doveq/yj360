@extends('Index.master')
@section('title')我的班级 @stop

@section('content')
<div class="container">
  <div><a href="/classes/create">创建班级</a> <a href="/training/create">新建重点训练</a> <a href="/message">消息({{Session::get('newmassage_count')}})</a></div>
  <div>
    <table>
      <thead>
        <tr>
          <th>序号</th>
          <th>班级名称</th>
          <th>创建人</th>
          <th>成员</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classes as $list)
        <tr id="classes_{{$list->id}}">
          <td>{{$list->id}}</td>
          <td><a href="/classes/{{$list->id}}">{{$list->name}}</a></td>
          <td>{{$list->teacher->name}}</td>
          <td>{{$list->students->count()}}</td>
          <td><a href="/classmate/create?class_id={{$list->id}}">添加成员</a> <a href="javascript:void(0);" onClick="delete_classes('{{$list->id}}');">删除</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <table>
      <thead>
        <tr>
          <th>序号</th>
          <th>训练名称</th>
          <th>时间</th>
          <th>状态操作</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($trainings as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td>{{$list->name}}</td>
          <td>{{$list->created_at}}</td>
          <td>
            <button class="btn_publish" data-id="{{$list->id}}" data-status="{{$list->status}}">{{$statusEnum[$list->status]}}</button>
          </td>
          <td>选题 <a href="/training_result?training_id={{$list->id}}">查看练习情况</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
  $(".btn_publish").on('click', function() {
    var $this = $(this);
    var training_id = $this.data("id");
    var training_status = $this.data("status");
    // var aa = $this.text();
    // alert(training_status);
    if (training_status == 0) {
      status_txt = '撤销发布';
      update_status = 1;
    } else if (training_status == 1) {
      status_txt = '发布';
      update_status = 0;
    }
    $.ajax({
      url:'/training/'+training_id,
      data: {status: update_status},
      // async:false,
      type:'put',
    })
    .fail(function(){
      alert('操作失败');
    })
    .success(function(){
      // alert(update_status);
      // $this.attr('data-status', update_status);
      // $this.text(status_txt)
      location.reload();
    });
  });
  delete_classes = function(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/classes/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $('#classes_'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  }
});
</script>
@stop


