@extends('Index.master')
@section('title')我的班级 @stop

@section('content')
<div class="container-fluid">
  @if ($query['column_id'])
    @include('Index.column.nav')
  @else
    @include('Index.profile.nav')
  @endif

  <div class="col-md-9">
      <div class="tabtool">
          <div class="clear"></div>
      </div>

      <div class="classes-list">

        @if (isset($lists['files']))
          @foreach($lists['files'] as $k => $d)
          <div><a href="/data/flash_exe/{{$d['path']}}index.php" target="_blank">{{$d['name']}}</a></div>
          @endforeach
        @else
          @foreach($lists as $k => $d)
          <div><a href="/courseware?d1={{$k}}&column_id={{$query['column_id']}}">{{$d['name']}}</a></div>
          @endforeach
        @endif
          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {

});
</script>
@stop


