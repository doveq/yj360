@extends('Index.master')
@section('title')我的消息 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
          发送消息 {{ HTML::ul($errors->all()) }}
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
        {{ Form::open(array('url' => '/message?column_id='.$query['column_id'], 'method' => 'post')) }}
          <table class="stable" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">{{ Form::label('inputName', '发送给:', array('class' => '')) }} </td>
            <td style="text-align:left;margin:10px;padding:10px;">  {{ Form::label('name', $user->name, array('class' => '')) }}</td>
          </tr>
          <tr>
            <td style="text-align:right;margin:10px;padding:10px;">{{ Form::label('inputContent', '内容:', array('class' => '')) }} </td>
            <td>{{ Form::textarea('content', '', array('class' => '', 'id' => 'inputContent', 'style' => 'width:100%', 'rows' => 4)) }}</td>
          </tr>
          <tr>
            <td></td>
            <td>{{ Form::hidden('receiver_id', $user->id, array('class' => '')) }}
{{ Form::submit('确定', array('class' => '')) }}</td>
          </tr>
      </table>
      {{ Form::close() }}

          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop

@section('js')
<script type="text/javascript">
</script>
@stop


