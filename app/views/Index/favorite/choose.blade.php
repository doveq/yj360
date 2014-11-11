<link href="/assets/css/index.css" rel="stylesheet">

<div class="row">
  @if (!empty($lists))
  <table class="table-2" style="width:80%;margin:20px;padding:20px" border="0" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th>{{ Form::checkbox('checkAll', 1, false, array('id' => 'checkAll')) }}</th>
        <th>题干</th>
        <th>题目类型</th>
        <th>收藏时间</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lists as $list)
      <tr>
        <td>{{ Form::checkbox('question_id[]', $list->id, false, array('id' => 'q'.$list->id)) }}</td>
        <td>{{$list->question->txt}}</td>
        <td>{{$list->question->type}}</td>
        <td>{{$list->created_at}}</td>
        <td>查看</td>
      </tr>
      <tr><td colspan="5">
              <div class="table-2-sp"></div>
          </td></tr>
      @endforeach
      <tr>
        <td colspan="5" style="text-align:center;">
          选择
        </td>
      </tr>
    </tbody>
  </table>
  @endif
</div>

<script type="text/javascript" src="/assets/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript">

$(function(){

  $("#checkAll").click(function() {
      $('input[name="question_id[]"]').prop("checked",this.checked);
  });
  var $subBox = $("input[name='question_id[]']");
  $subBox.click(function(){
      $("#checkAll").prop("checked",$subBox.length == $("input[name='question_id[]']:checked").length ? true : false);
  });

});
</script>