@extends('Index.master')
@section('title')邀请人
@stop

@section('content')
<div class="container wrap regbox">

  {{ Form::open(array('url' => '/do_invite_by', 'method' => 'post')) }}
  <div class="invite-box">
    <div style="text-align:center;background-color:#E7B190;color:#fff;padding:10px"><h2>请填写邀请人真实姓名（必填）</h2></div>
    <br/>
    @if (isset($error))
      <div style="text-align:center;margin:5px;">{{$error}}</div>
    @endif
    <div style="text-align:center;">{{ Form::text('name', '', array('class' => 'tyinput', 'id' => 'inputName','style' => 'width:200px'))}}</div>
    <br/>
    <div style="text-align:center;">{{ Form::submit('', array('class' => 'nextbtn')) }}</div>
    <br/>
    <div style="text-align:center;margin:5px;color:#ff0000">没有邀请人, 但我想注册怎么办?</div>
    <div style="text-align:center;margin:5px;color:#5ABC61">请加入QQ群:249878625</div>
  </div>
  {{ Form::close() }}
</div> <!-- /container -->
<br/>
@stop

@section('js')
@stop