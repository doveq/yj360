@extends('Admin.master_column')
@section('title')科目内容管理@stop

@section('nav')
  @include('Admin.item_content.nav')
@stop

@section('content')
  <div class="container-fluid">
    <blockquote>
        <h3>{{$subject['name']}} 内容管理</h3>
    </blockquote>
    <div class='row'>
      @foreach($items as $item)
        <div class="col-md-3 well text-center">
            <a href="/admin/item_content/create?subject_id={{$query['subject_id']}}&subject_item_id={{$item->id}}"><i class="glyphicon glyphicon-plus icon-4x"></i><br/><span>{{$item->name}}</span></a>
        </div>
      @endforeach
    </div>
  </div>

@stop
