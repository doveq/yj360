<link href="/assets/css/index.css" rel="stylesheet">

<div class="row">
  @if (!empty($lists))
  {{ Form::open(array('url' => '/favorite/doChoose', 'method' => 'post')) }}
  <table class="table-2" style="width: 100%; margin: 20px; padding: 20px 60px 20px 20px;" border="0" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th>{{ Form::checkbox('checkAll', 1, false, array('id' => 'checkAll')) }}</th>
        <th>题干</th>
        <!-- <th>题目类型</th> -->
        <th>收藏时间</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lists as $list)
      <tr>
        <td style="padding:15px;">{{ Form::checkbox('question_id[]', $list->id, false, array('id' => 'q'.$list->id)) }}</td>
        <td style="padding:15px;">{{$list->question->txt}}</td>
        <td style="padding:15px;">{{$list->created_at}}</td>
        <td style="padding:15px;"><a href="/topic?id={{$list->question_id}}&column_id={{$query['column_id']}}&from=favorite" target="_blank">查看</a></td>
      </tr>
      <tr><td colspan="5">
              <div class="table-2-sp"></div>
          </td></tr>
      @endforeach
      <tr>
        <td colspan="5" style="text-align:center; padding:15px;">
          {{ Form::hidden('training_id', $query['training_id']) }}
          {{ Form::hidden('column_id', $query['column_id']) }}
          {{ Form::button('选题', array('class' => 'btnsubmit')) }}
        </td>
      </tr>
    </tbody>
  </table>
  {{ Form::close() }}
  @else
  <div style="text-align:center;margin-top:50px;">收藏夹为空</div>
  @endif
</div>

<script type="text/javascript" src="/assets/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/layer/layer.min.js"></script>

<script type="text/javascript">

$(function(){

  $("#checkAll").click(function() {
      $('input[name="question_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='question_id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='question_id[]']:checked").length ? true : false);
  });

  $(".btnsubmit").on('click', function() {
    var idarray = new Array();
    $('input[name="question_id[]"]:checked').each(function(){
      idarray.push($(this).val());
    });
    $.ajax({
        url:'/favorite/doChoose',
        type:'post',
        data: {question_id:idarray,column_id:{{$query['column_id']}},training_id:{{$query['training_id']}} },
      })
      .fail(function(){
        layer.msg('选择失败', 2, 3);
      })
      .success(function(data){
        layer.msg('选择成功', 2, 1,function(){
            // window.location.href='/training?column_id={{$query['column_id']}}';
            layer.closeAll();
          });
    });

  });

});
</script>