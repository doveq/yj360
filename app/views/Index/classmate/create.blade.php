@extends('Index.master')
@section('title')我的班级@stop

@section('content')
<div class="container">
  {{ Form::open(array('url' => '/classmate/create','role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
    <div class="form-group">
      {{ Form::label('inputName', '用户名', array('class' => 'sr-only')) }}
      {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '用户名')) }}
    </div>
    <div class="form-group">
      {{ Form::label('inputTel', '手机号', array('class' => 'sr-only')) }}
      {{ Form::text('tel', $query['tel'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '手机号')) }}
    </div>
    {{ Form::hidden('class_id', $classes->id) }}
    {{ Form::button('查找', array('class' => 'btn btn-primary', 'type' =>'submit')) }}
  {{ Form::close() }}
  <div>
  {{ Form::open(array('url' => '/classmate/', 'method' => 'post')) }}
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">ID</th>
          <th class="text-center">名称</th>
          <th class="text-center">性别</th>
          <th class="text-center">电话</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($students as $list)
        <tr class="text-center">
          <td>
            @if ($list->checked === 1)
            {{ Form::checkbox('student_id[]', $list->id, true, array('id' => 'userid'.$list->id)) }}
            @else
            {{ Form::checkbox('student_id[]', $list->id, false, array('id' => 'userid'.$list->id)) }}
            @endif
          </td>
          <td>
            {{ Form::label('userid'.$list->id, $list->id) }}
          </td>
          <td>
            {{ Form::label('userid'.$list->id, $list->name) }}
          </td>
          <td>{{ $genderEnum[$list->gender] }}</td>
          <td>{{ $list->tel }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="col-md-12">
      <div class="col-md-6 text-right">
        {{ Form::hidden('class_id', $classes->id, array('id' => 'class_id')) }}
        {{ Form::button('邀请', array('class' => '', 'type' =>'submit')) }}
        {{ Form::checkbox('check_all', 1, false, array('id' => 'check_all')) }}
        {{ Form::label('check_all', '全选') }}
      </div>
      <div class="col-md-6 text-right">
        {{$students->appends(Input::all())->links()}}
      </div>
    </div>
  {{ Form::close() }}

  </div>
</div> <!-- /container -->
@stop