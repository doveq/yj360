@extends('Admin.master_column')
@section('title')真题题库@stop


@section('content')


<div class="row">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="/admin/examPaper/clist?id={{$epParent->id}}">{{$epParent->title}}</a></li>
      <li><a href="/admin/examPaper/qlist?id={{$ep->id}}">{{$ep->title}}</a></li>
    </ol>
  </div>

  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
      <input type="hidden" id="exam-id" name="id" value="{{$query['id']}}">

      <div class="form-group" id="sort2" style="padding-right:60px;">
          {{Form::select('sort1', array(), '', array('class' => 'sort1 form-control', 'data-value' => $query['sort1'] ))}}
          {{Form::select('sort2', array(), '', array('class' => 'sort2 form-control', 'data-value' => $query['sort2'] ))}}
          {{Form::select('sort3', array(), '', array('class' => 'sort3 form-control', 'data-value' => $query['sort3'] ))}}
          {{Form::select('sort4', array(), '', array('class' => 'sort4 form-control', 'data-value' => $query['sort4'] ))}}
          {{Form::select('sort5', array(), '', array('class' => 'sort5 form-control', 'data-value' => $query['sort5'] ))}}
      </div>
      <div class="clearfix"></div>

      <div class="form-group">
        {{ Form::label('inputType', '类型', array('class' => 'sr-only')) }}
        {{ Form::select('type', $typeEnum, $query['type'], array('class' => 'form-control', 'id' => 'inputType')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputName', '题干', array('class' => 'sr-only')) }}
        {{ Form::text('txt', $query['txt'], array('class' => 'form-control', 'id' => 'inputName', 'placeholder' => '题干')) }}
      </div>
      <div class="form-group">
        {{ Form::label('inputTel', '原始编号', array('class' => 'sr-only')) }}
        {{ Form::text('source', $query['source'], array('class' => 'form-control', 'id' => 'inputTel', 'placeholder' => '原始编号')) }}
      </div>
      <!--
      <div class="form-group">
        {{ Form::label('inputStatus', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputStatus')) }}
      </div>
      -->
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>

  

  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>{{ Form::checkbox('checkAll', 1,false, array('id' => 'checkAll')) }}</th>
            <th>题干</th>
            <th>原始编号</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $info)
          <tr>
            <td><label>{{ Form::checkbox('question_id[]', $info['id']) }} {{ $info['id'] }}</label></td>
            <td><a href="/topic?id={{ $info['id'] }}" target="_blank">{{$info['txt']}}</a></td>
            <td>{{$info['source']}}</td>
            <td>
              {{$statusEnum[$info['status']]}}
            </td>
            <td>
                <a href="javascript:;" class="btn btn-primary btn-xs btn-add" data-id="{{$info['id']}}">添加到试卷</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row">
      <div class="col-md-2">
          <button type="button" class="btn btn-primary btn-addall">批量添加到试卷</button>
      </div>
      <div class="col-md-10 text-right">
      {{$paginator->links()}}
      </div>
  </div>
  
  
@stop

@section('js')
{{ HTML::script('/assets/jquery.cxselect.min.js') }}
<script type="text/javascript">
$(function(){
  // http://code.ciaoca.com/jquery/cxselect/
  $.cxSelect.defaults.url = '/admin/column.json';
 
  $('#sort2').cxSelect({
      url:'/admin/sort.json',
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
    $id = $("#exam-id").val();

      $.post("/admin/relation/doExam",
        {
          question_id: question_ids,
          id: $id
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