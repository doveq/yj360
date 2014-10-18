@extends('Index.master')
@section('title')发送消息 @stop

@section('content')
<div class="container">
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => '/message', 'method' => 'post')) }}
{{ Form::label('inputName', '发送给:', array('class' => '')) }}
{{ Form::text('name', $user->name, array('class' => '', 'id' => 'inputName', 'disabled' => 1)) }}
{{ Form::label('inputContent', '内容:', array('class' => '')) }}
{{ Form::textarea('content', '', array('class' => '', 'id' => 'inputContent')) }}

{{ Form::hidden('receiver_id', $user->id, array('class' => '')) }}
{{ Form::submit('确定', array('class' => '')) }}
{{ Form::close() }}
</div> <!-- /container -->
@stop