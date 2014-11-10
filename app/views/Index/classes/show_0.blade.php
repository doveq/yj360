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
        <a href="/classes?column_id={{$query['column_id']}}" style="color:#499626;"><返回</a>
        <a>班级成员</a>
        @if ($classmate->count() > 0)
        <a href="javascript:;" class="quit_class" style="float:right;color:#499626;" onclick="quit_class({{$classmate[0]->id}});">退出班级</a>
        @endif
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div>
        <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>姓名</th>
              <th>性别</th>
              <th>电话</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $list)
            <tr id="{{$list->pivot->id}}">
              <td>{{$list->name}}</td>
              <td>{{$genderEnum[$list->gender]}}</td>
              <td>{{$list->tel}}</td>
              <td><a href="/message/create?receiver_id={{$list->id}}&column_id={{$query['column_id']}}">私信</a></td>
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
function quit_class(classmateid)
  {
    $.ajax({
      url:'/classmate/'+classmateid,
      data: {status: status},
      // async:false,
      type:'delete',
    })
    .fail(function(){
      alert('操作失败');
    })
    .success(function(){
      // alert(update_status);
      // $this.attr('data-status', update_status);
      // $this.text(status_txt)
      // location.reload();
      window.location.replace("/classes?column_id={{$query['column_id']}}");
    });
  }
</script>
@stop