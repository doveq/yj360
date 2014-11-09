@extends('Admin.master_column')
@section('title')试卷管理@stop


@section('content')
 {{--
  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
      <li class="active">试卷管理</li>
    </ol>
  </div>
  --}}

  <div class="row">

        @if(!empty($info->id))
        <form method="POST" action="/admin/examPaper/doEdit" role="form" class="form-horizontal">
        <input type="hidden" name="id" value="{{$info->id or ''}}" />
        @else
        <form method="POST" action="/admin/examPaper/doAdd" role="form" class="form-horizontal">
        @endif

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">分类</label>
          <div class="col-md-6" id="sort">
              {{Form::select('sort1', array(), '', array('class' => 'sort1', 'data-value' => $info['sort1'] ))}}
              {{Form::select('sort2', array(), '', array('class' => 'sort2', 'data-value' => $info['sort2'] ))}}
              {{Form::select('sort3', array(), '', array('class' => 'sort3', 'data-value' => $info['sort3'] ))}}
              {{Form::select('sort4', array(), '', array('class' => 'sort4', 'data-value' => $info['sort4'] ))}}
              {{Form::select('sort5', array(), '', array('class' => 'sort5', 'data-value' => $info['sort5'] ))}}
          </div>
        </div>

        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">试卷名</label>
          <div class="col-md-6">
            <input class="form-control" id="title" name="title" type="text" value="{{$info->title or ''}}">
          </div>
        </div>
        <!--
        <div class="form-group">
          <label for="sort_name" class="col-md-2 control-label">价格</label>
          <div class="col-md-6">
            <input class="form-control" name="price" type="text" value="{{$info->price or '0'}}">
          </div>
        </div>
        -->
        <div class="form-group">
          <label class="col-md-2 control-label" for="desc">描述</label>
          <div class="col-md-6">
            <textarea cols="50" name="desc" rows="3" id="desc" class="form-control">{{$info->desc or ''}}</textarea>
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <input type="submit" value="提交" class="btn btn-default">
           </div>
        </div>

      </form>
  </div>
@stop

@section('js')
{{ HTML::script('/assets/jquery.cxselect.min.js') }}
<script type="text/javascript">
$(function(){
  // http://code.ciaoca.com/jquery/cxselect/
  $.cxSelect.defaults.url = '/admin/examSort.json';
  $('#sort').cxSelect({
      url:'/admin/examSort.json',
      firstTitle: '-请选择-分类-',
      selects: ['sort1', 'sort2', 'sort3', 'sort4', 'sort5'],
      nodata: 'none'
  });
});
</script>
@stop
