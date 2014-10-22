@extends('Admin.master_column')
@section('title')产品管理 @stop

@section('nav')
  @include('Admin.product.nav')
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.product.index', '产品管理')}}</li>
      <li class="active">编辑产品</li>
    </ol>
  </div>

  <div class="row">
      {{ HTML::ul($errors->all(), array('class' => 'bg-warning')) }}
      {{ Form::open(array('url' => '/admin/product/' . $product->id, 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}
        <div class="form-group">
          {{ Form::label('inputName', '名称', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('name', $product->name, array('class' => 'form-control', 'id' => 'inputName')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPrice', '价格', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('price', $product->price, array('class' => 'form-control', 'id' => 'inputPrice')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPeriod', '有效期', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::text('period', $product->valid_period, array('class' => 'form-control', 'id' => 'inputPeriod')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputPolicy', '策略', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
<!--             {{ Form::select('policy', $policyEnum, $product->policy, array('class' => 'form-control', 'id' => 'inputPolicy')) }}
 -->
            {{ Form::label('inputPolicy', $policyEnum[$product->policy], array('class' => 'control-label')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('inputColumn', '科目', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            {{ Form::label('inputColumn', $product->column->name, array('class' => 'control-label')) }}
          </div>
        </div>
        @if ($product->policy == 1)
        <div class="form-group choose_question">
          {{ Form::label('inputFree', '选择免费题目', array('class' => 'col-md-2 control-label')) }}
          <div class="col-md-6">
            <ul class="list-group">
              @foreach($questions as $list)
              <li class="list-group-item">
                <div class="checkbox">
                  <label>{{ Form::checkbox('question[]', $list->id, in_array($list->id, $free_questions)?1:0) }} {{$list->txt}}</label>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            {{ Form::hidden('column_id', $product->column->id) }}
            {{ Form::hidden('policy', $product->policy) }}
            {{ Form::submit('提交', array('class' => 'btn btn-default')) }}
           </div>
        </div>
      {{ Form::close() }}
  </div>
@stop