@extends('Admin.master_column')
@section('title')添加内容@stop

@section('nav')
  @include('Admin.product.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.product.index', '产品管理')}}</li>
      <li class="active">添加产品</li>
    </ol>
  </div>

  <div class="row">
      {{ HTML::ul($errors->all()) }}
      {{ Form::open(array('url' => '/admin/product/', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal','files' => true)) }}
        <div class="form-group">
          {{ Form::label('inputName', '名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', $column->name, array('class' => 'form-control', 'id' => 'inputName')) }}
            <p class="help-block">默认使用科目名称,可以修改</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPrice', '价格', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('price', '', array('class' => 'form-control', 'id' => 'inputPrice')) }}
            <p class="help-block">格式: 20.50</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPeriod', '有效期', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('period', '', array('class' => 'form-control', 'id' => 'inputPeriod')) }}
            <p class="help-block">格式: 2014-10-21</p>
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPolicy', '策略', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::select('policy', $policyEnum, '', array('class' => 'form-control', 'id' => 'inputPolicy')) }}
            <p class="help-block">如果选择部分免费,则需指定免费题目</p>
          </div>
        </div>
        <div class="form-group choose_question">
          {{ Form::label('inputFree', '选择免费题目', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            <ul class="list-group">
              @foreach($questions as $list)
              <li class="list-group-item">
                <div class="checkbox">
                  <label>{{ Form::checkbox('question[]', $list->id,false) }} {{$list->txt}}</label>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            {{ Form::hidden('column_id', $column->id) }}
            {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
           </div>
        </div>
      {{ Form::close() }}
  </div>
@stop

@section('js')
<script type="text/javascript">
$(function(){
  $(".choose_question").hide();

  $('#inputPolicy').change(function() {
    // alert($(this).val());
    var $thisid = $(this).val();
    if ($thisid == 1) {
      $(".choose_question").show();
    } else {
      $(".choose_question").hide();
    }
  });

});
</script>
@stop


