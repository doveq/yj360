@extends('Index.master')
@section('title')我的消息 @stop

@section('content')
<div class="container">
  <div>
    <div>发送者:{{$message->sender->name}}</div>
    <div>发送时间:{{$message->created_at}}</div>
    <div>内容:{{$message->content}}</div>
  </div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">

</script>
@stop