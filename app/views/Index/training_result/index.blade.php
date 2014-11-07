@extends('Index.master')
@section('title')重点训练@stop

@section('content')
<div class="container-column wrap">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

  <div class="wrap-right">
      <div class="tabtool">
        <div > 训练结果 </div>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div>
        <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            @foreach ($lists as $user_id => $list)
              <tr>
                <td>{{$list['name']}}</td>
                <td><a href="/message/create?receiver_id={{$user_id}}">私信TA</a></td>
                <td>
                  @if (isset($list[1]))
                  正确
                  {{count($list[1])}}
                  @endif
                  @if (isset($list[0]))
                   错误{{count($list[0])}}
                  @endif
                 </td>
                <td>
                  @if (isset($list[0]))
                  错题是:
                  @foreach ($list[0] as $n)
                  第{{$n}}题
                  @endforeach
                  @endif
                </td>
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