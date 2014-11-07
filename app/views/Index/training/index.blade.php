@extends('Index.master')
@section('title')重点训练 @stop

@section('content')
<div class="container-column wrap">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

  <div class="wrap-right">
      <div class="tabtool">
        @if ($query['column_id'])
          <a href="/classes/create?column_id={{$query['column_id']}}"><img src="/assets/img/addclasses.jpg" /></a>
          <a href="/training/create?column_id={{$query['column_id']}}"><img src="/assets/img/addzdxl.jpg" /></a>
        @else
          <a href="/classes/create"><img src="/assets/img/addclasses.jpg" /></a>
          <a href="/training/create"><img src="/assets/img/addzdxl.jpg" /></a>
        @endif
        <a href="/message" class="tabtool-msg">消息(<span>{{Session::get('newmassage_count')}}</span>)</a>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
        <table  class="stable" border="0" cellpadding="0" cellspacing="0">
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
            @foreach ($lists as $list)
            <tr>
              <td>{{$list->id}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->created_at}}</td>
              <td>
                <button class="btn_publish" data-id="{{$list->id}}" data-status="{{$list->status}}">{{$statusEnum[$list->status]}}</button>
              </td>
              <td>选题 <a href="/training_result?training_id={{$list->id}}&column_id={{$query['column_id']}}">查看练习情况</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>

  </div>
  <div class="clear"></div>
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

});
</script>
@stop


