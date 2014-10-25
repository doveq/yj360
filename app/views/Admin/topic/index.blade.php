@extends('Admin.master_column')
@section('title')真题题库@stop


@section('content')
<div class="row">
  <div class="row text-right">
    {{ Form::open(array('role' => 'form', 'class' => 'form-inline', 'method' => 'get')) }}
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
      <div class="form-group">
        {{ Form::label('inputStatus', '状态', array('class' => 'sr-only')) }}
        {{ Form::select('status', $statusEnum, $query['status'], array('class' => 'form-control', 'id' => 'inputStatus')) }}
      </div>
      {{ Form::button('查找', array('class' => 'btn btn-info', 'type' =>'submit')) }}
    {{ Form::close() }}
  </div>

<!--   <div class="row text-right">
      {{$paginator->links()}}
  </div> -->
  <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>{{ Form::checkbox('checkAll', 1,false, array('id' => 'checkAll')) }}</th>
            <th>题干</th>
            <th>原始编号</th>
            <th>状态</th>
            <th>添加时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($list as $info)
          <tr>
            <td><label>{{ Form::checkbox('question_id[]', $info['id']) }} {{ $info['id'] }}</label></td>
            <td><a href="/topic?id={{ $info['id'] }}" target="_blank">{{$info['txt']}}</a></td>
            <td>{{$info['source']}}</td>
            <td>{{$statusEnum[$info['status']]}}</td>
            <td>{{$info['created_at']}}</td>
            <td>
              <div class="btn-group btn-xs">
                  <a class="btn btn-default btn-xs" href="{{url('/admin/topic/edit?id='. $info['id']) }}"><i class="icon-edit"></i> 编辑</a>
                  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span></a>
                  <ul class="dropdown-menu">
                      @if($info['status'] === 1)
                      <li><a style='color:#999;'><i class="icon-ok"></i> 有效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="0"><i class="icon-remove"></i> 无效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="-1"><i class="icon-remove"></i> 审核未通过</a></li>
                      @elseif($info['status'] === 0)
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="1"><i class="icon-ok"></i> 有效</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 无效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="-1"><i class="icon-remove"></i> 审核未通过</a></li>
                      @else
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="1"><i class="icon-ok"></i> 有效</a></li>
                      <li><a href="#" class="btn_publish" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="0"><i class="icon-remove"></i> 无效</a></li>
                      <li><a style='color:#999;'><i class="icon-remove"></i> 审核未通过</a></li>
                      @endif
                      <li class="divider"></li>
                      <li><a href="#" class="btn_delete" data-toggle="modal" data-id="{{$info['id']}}" data-val="{{$info['id']}}" data-status="1"><i class="icon-trash"></i> 删除</a></li>
                  </ul>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="row text-right">
      {{$paginator->links()}}
  </div>
  <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4 alertInfo">
    </div>
    <div class="col-md-4">
      {{ Form::button('批量下架', array('class' => 'btn btn-danger btn-xs pull-right doQuestion', 'id' => 'downQuestion', 'style' => 'margin:10px')) }}
      {{ Form::button('批量上线', array('class' => 'btn btn-primary btn-xs pull-right doQuestion', 'id' => 'upQuestion', 'style' => 'margin:10px')) }}
    </div>
  </div>
  <div class="row" id="sort" style="margin:10px;">
    批量转移到分类:
    {{Form::select('sort1', array(), '', array('class' => 'sort1'))}}
    {{Form::select('sort2', array(), '', array('class' => 'sort2'))}}
    {{Form::select('sort3', array(), '', array('class' => 'sort3'))}}
    {{Form::select('sort4', array(), '', array('class' => 'sort4'))}}
    {{Form::select('sort5', array(), '', array('class' => 'sort5'))}}
    {{ Form::button('批量转移', array('class' => 'btn btn-primary btn-xs', 'id' => 'addSort')) }}
  </div>
  <div class="row" id="column" style="margin:10px;">
    批量加入到科目:
    {{Form::select('column1', array(), '', array('class' => 'column1'))}}
    {{Form::select('column2', array(), '', array('class' => 'column2'))}}
    {{Form::select('column3', array(), '', array('class' => 'column3'))}}
    {{Form::select('column4', array(), '', array('class' => 'column4'))}}
    {{Form::select('column5', array(), '', array('class' => 'column5'))}}
    {{ Form::button('批量转移', array('class' => 'btn btn-primary btn-xs', 'id' => 'addColumn')) }}
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {{ Form::open(array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'myModalForm', 'method' => 'post')) }}
    {{ Form::hidden('qid', '', array('id' => 'user_id')) }}
    {{ Form::hidden('status', '', array('id' => 'user_status')) }}
    {{ Form::hidden('_method', '', array('id' => 'form_method')) }}

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body" id="myModalBody">
        </div>
        <div class="modal-footer">
          {{ Form::button('取消', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
          {{ Form::button('确定', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
@stop

@section('js')
{{ HTML::script('/assets/jquery.cxselect.min.js') }}
<script type="text/javascript">
$(function(){
  // http://code.ciaoca.com/jquery/cxselect/
  $.cxSelect.defaults.url = '/admin/column.json';
  $('#column').cxSelect({
      url:'/admin/column.json',
      // required: 'true',
      firstTitle: '-请选择-科目-',
      selects: ['column1', 'column2', 'column3', 'column4', 'column5'],
      nodata: 'none'
  });
  $('#sort').cxSelect({
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
  $("#addSort").bind("click", function(){
      $this = $(this);
      var $item = $('input[name="question_id[]"]:checked');
      // alert($item);
      if ($item.length <= 0) {
        alert('请选择题目');
        return;
      }
      var $sort = $this.prevAll('select:visible').val();
      if ($sort == 0) {
        alert('请选择分类');
        return;
      }

      var $question_ids = new Array();
      $item.each(function(){
        $question_ids.push($(this).val());
      });

      $.post("/admin/relation/sort",
        {
          question_id: $question_ids,
          sort_id: $sort

        },
        function(data) {
            $('<span class="label label-success">'+data.info+'</span>').appendTo('.alertInfo').fadeOut(5000);
        },
        "json"
      )
      .fail(function(){
          $('<span class="label label-danger">操作失败</span>').appendTo('.alertInfo').fadeOut(5000);
      });
      return false;
  });

  //批量转移分类
  $("#addColumn").bind("click", function(){
      $this = $(this);
      var $item = $('input[name="question_id[]"]:checked');
      // alert($item);
      if ($item.length <= 0) {
        alert('请选择题目');
        return;
      }
      var $column = $this.prevAll('select:visible').val();
      if ($column == 0) {
        alert('请选择科目');
        return;
      }

      var $question_ids = new Array();
      $item.each(function(){
        $question_ids.push($(this).val());
      });

      $.post("/admin/relation/column",
        {
          question_id: $question_ids,
          column_id: $column

        },
        function(data) {
            $('<span class="label label-success">'+data.info+'</span>').appendTo('.alertInfo').fadeOut(5000);
        },
        "json"
      )
      .fail(function(){
          $('<span class="label label-danger">操作失败</span>').appendTo('.alertInfo').fadeOut(5000);
      });
      return false;
  });

  $(".doQuestion").bind("click", function(){
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
    var $status;
    // alert($this.attr('id'));
    if ($this.attr('id') == 'downQuestion') {
      $status = '-1';
    }
    if ($this.attr('id') == 'upQuestion') {
      $status = '1';
    }
    if(confirm('您确定要批量修改吗？')){
      $.post("/admin/relation/do_question",
        {
          question_id: $question_ids,
          status: $status

        },
        function(data) {
            $('<span class="label label-success">'+data.info+'</span>').appendTo('.alertInfo').fadeOut(5000);
        },
        "json"
      )
      .fail(function(){
          $('<span class="label label-danger">操作失败</span>').appendTo('.alertInfo').fadeOut(5000);
      });
    }
    return false;
  });

  //发布,下线
  $(".btn_publish").bind("click", function(){
      var $this = $(this);
      var user_id = $this.data("id");
      var user_val = $this.data("val");
      var user_status = $this.data("status");
      if (user_id <= 0) {
          alert("data error");
          return false;
      }
      if (user_status == '1') {
        status_txt = '有效';
      } else if (user_status == '0') {
        status_txt = '无效';
      } else {
        status_txt = '审核未通过';
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要把#'+user_val+'设置成' + status_txt + '吗?');
      $("#user_id").val(user_id);
      $("#user_status").val(user_status);
      $("#myModalForm").attr('action', '{{ url('/admin/topic/doEdit') }}');
      $("#form_method").attr('value', 'post');
      $('#myModal').modal('show');
  });
  //删除
  $(".btn_delete").bind("click", function(){
      var $this = $(this);
      var user_id = $this.data("id");
      var user_val = $this.data("val");
      if (user_id <= 0) {
          alert("data error");
          return false;
      }
      $("#myModalLabel").html('提示:');
      $("#myModalBody").html('你确定要删除 #'+user_val+' 吗?');
      $("#myModalForm").attr('action', '/admin/topic/doDel?qid='+ user_id);
      $("#form_method").attr('value', 'get');
      $('#myModal').modal('show');
  });
});
</script>
@stop