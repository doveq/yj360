@extends('Admin.master_column')
@section('title')科目内容@stop

@section('nav')
  @include('Admin.subject_content.nav', array_merge((array)$subject,(array)$items))
@stop

@section('content')
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.subject.index', '科目管理')}}</li>
      <li class="active">内容管理</li>
    </ol>
  </div>
  <div class="row">
      hahaha
  </div>
@stop


