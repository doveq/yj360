@extends('Admin.master_column')
@section('title')编辑科目功能@stop

@section('nav')
  @include('Admin.subject.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">科目管理</a></li>
      <li class="active">编辑科目功能</li>
    </ol>
  </div>
  <div class="row">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">选择 {{$subject['name']}} 功能</h3>
        </div>
        <div class="panel-body">
          {{ HTML::ul($errors->all()) }}
          {{ Form::open(array('route' => array('admin.subject_item_relation.update',$subject['id']), 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
          <div class="form-group">
              <div class="col-md-offset-2 col-md-6">
                @foreach($subject_items as $k => $v)
                <div class="checkbox">
                  <label>
                    <!-- <input type="checkbox" value="{{$v->id}}"> {{$v->name}} -->
                    {{ Form::checkbox('relations[]', $v->id, $v->checked )}} {{ $v->name }}
                  </label>
                </div>
                @endforeach
              </div>
          </div>
          <div class="form-group">
            <div class="col-md-offset-2 col-md-6">
              <hr/>
              {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
             </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
  </div>
@stop


