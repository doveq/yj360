@extends('Index.master')
@section('title')新建重点训练@stop

@section('content')
<div class="container">
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => '/training', 'method' => 'post')) }}
{{ Form::label('inputName', '训练名称', array('class' => '')) }}
{{ Form::text('name', '', array('class' => '', 'id' => 'inputName')) }}
{{ Form::submit('确定', array('class' => '')) }}
{{ Form::close() }}
</div> <!-- /container -->
@stop