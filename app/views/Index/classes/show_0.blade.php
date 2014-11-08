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
        <a>班级成员</a>
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
            @foreach ($classes->students as $list)
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

</script>
@stop