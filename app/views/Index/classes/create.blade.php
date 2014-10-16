@extends('Index.master')
@section('title')新建班级@stop

@section('content')
<div class="container">
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => '/classes', 'method' => 'post')) }}
{{ Form::label('inputName', '班级名称', array('class' => '')) }}
{{ Form::text('name', '', array('class' => '', 'id' => 'inputName')) }}
{{ Form::submit('确定', array('class' => '')) }}
{{ Form::close() }}
</div> <!-- /container -->
@stop