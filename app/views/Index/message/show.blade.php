@extends('Index.master')
@section('title')我的消息 @stop

@section('content')
<div class="container-column wrap">
  @include('Index.profile.nav')

  <div class="wrap-right">
      <div class="tabtool">
          <a href="/message" class="tabtool-msg">查看消息 {{ HTML::ul($errors->all()) }}</a>
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
                      {{ Form::open(array('url' => '/message', 'method' => 'post')) }}
          <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">{{ Form::label('inputName', '发送者: ', array('class' => '')) }} </td>
            <td style="text-align:left;margin:10px;padding:10px;">  {{ $message->sender->name}}</td>
          </tr>
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">{{ Form::label('inputName', '发送时间: ', array('class' => '')) }} </td>
            <td style="text-align:left;margin:10px;padding:10px;">  {{ $message->created_at}}</td>
          </tr>
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">{{ Form::label('inputName', '内容: ', array('class' => '')) }} </td>
            <td style="text-align:left;margin:10px;padding:10px;">  {{ $message->content}}</td>
          </tr>
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">回复:</td>
            <td>
              {{ Form::textarea('content', '', array('class' => '', 'id' => 'inputContent', 'style' => 'width:100%', 'rows' => 4)) }}
            </td>
          </tr>
          <tr>
            <td></td>
            <td>{{ Form::hidden('receiver_id', $message->sender->id, array('class' => '')) }}
{{ Form::submit('确定', array('class' => '')) }}</td>
          </tr>
      </table>
            {{ Form::close() }}

          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
</script>
@stop


