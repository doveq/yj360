@extends('Admin.master_column')
@section('title')试卷管理@stop

@section('content')

  <div class="row">
    <ol class="breadcrumb">
      <li>{{link_to_route('admin.column.index', '科目管理')}}</li>
        @foreach ($paths as $key => $path)
        <li>{{link_to_route('admin.column.index', $path['name'], array('parent_id' => $path['id']))}}</li>
        @endforeach
        <li>添加试卷</li>
    </ol>
  </div>

  <div class="row">
      <div class="row text-right">
        {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
          <div class="form-group" id="sort" style="padding-right:56px;">
              {{Form::select('sort1', array(), '', array('class' => 'sort1 form-control', 'data-value' => $query['sort1'] ))}}
              {{Form::select('sort2', array(), '', array('class' => 'sort2 form-control', 'data-value' => $query['sort2'] ))}}
              {{Form::select('sort3', array(), '', array('class' => 'sort3 form-control', 'data-value' => $query['sort3'] ))}}
              {{Form::select('sort4', array(), '', array('class' => 'sort4 form-control', 'data-value' => $query['sort4'] ))}}
              {{Form::select('sort5', array(), '', array('class' => 'sort5 form-control', 'data-value' => $query['sort5'] ))}}
          </div>
          <div class="clearfix"></div>

          <div class="form-group">
            {{ Form::label('inputName', '试卷名', array('class' => 'sr-only')) }}
            {{ Form::text('name', $query['name'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '试卷名')) }}
          </div>
          {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
        {{ Form::close() }}
      </div>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>{{ Form::checkbox('checkAll', 1,false, array('id' => 'checkAll')) }}</th>
            <th>试卷</th>
            <th>描述</th>
            <th>状态</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($lists as $list)
              <tr>
                <td>{{ Form::checkbox('question_id[]', $list->id) }} {{$list->id}}</td>
                <td><a href="/admin/examPaper/clist?id={{$list->id}}">{{$list->title}}</a></td>
                <td>{{$list->desc}}</td>
                <td>
                    @if ($list->status == 1)
                    <span class="label label-info">{{$statusEnum[$list->status]}}</span>
                    @elseif ($list['status'] == 0)
                    <span class="label label-warning">{{$statusEnum[$list->status]}}</span>
                    @else
                    <span class="label label-default">{{$statusEnum[$list->status]}}</span>
                    @endif
                </td>
                <td>
                  <a href="javascript:;" class="btn btn-primary btn-xs btn-add" data-id="{{$list->id}}">添加到科目</a>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
  </div>
  <div class="row ">
      <div class="col-md-2">
          <button type="button" class="btn btn-primary btn-addall">批量添加到科目</button>
      </div>
      <div class="text-right">
        {{$lists->appends($query)->links()}}
      </div>
  </div>

@stop

@section('js')
{{ HTML::script('/assets/jquery.cxselect.min.js') }}
<script type="text/javascript">

var column_id = {{$query['column_id']}};

$(function(){

  // http://code.ciaoca.com/jquery/cxselect/
  $.cxSelect.defaults.url = '/admin/examSort.json';
  $('#sort').cxSelect({
      url:'/admin/examSort.json',
      firstTitle: '-请选择-分类-',
      selects: ['sort1', 'sort2', 'sort3', 'sort4', 'sort5'],
      nodata: 'none'
  });


  $("#checkAll").click(function() {
      $('input[name="question_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='question_id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='question_id[]']:checked").length ? true : false);
  });

  //批量转移分类
  $(".btn-addall").bind("click", function(){
      $this = $(this);
      var $item = $('input[name="question_id[]"]:checked');
      // alert($item);
      if ($item.length <= 0) {
        alert('请选择题目');
        return;
      }

      var $question_ids = new Array();
      $item.each(function(){
        $question_ids.push($(this).val());
      });

      doAdd($question_ids);

      return false;
  });

  $(".btn-add").click(function(){
      doAdd($(this).data('id'));
      return false;
  });

});

function doAdd(question_ids)
{
    $.post("/admin/relation/columnExam",
      {
        exam_id: question_ids,
        column_id: column_id
      },
      function(data) {
          alert(data.info);
          location.reload();
      },
      "json"
    )
    .fail(function(){
        alert('操作失败，请刷新页面重试');
    });
    return false;
}

</script>
@stop
