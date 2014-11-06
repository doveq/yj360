<div class="row">
  @if (!empty($lists))
  <table class="table table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>题干</th>
        <th>题目类型</th>
        <th>收藏时间</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lists as $list)
      <tr>
        <td>{{ Form::checkbox('question_id[]', $list->id, false, array('id' => 'q'.$list->id)) }}</td>
        <td>{{$list->question->txt}}</td>
        <td>{{$list->question->type}}</td>
        <td>{{$list->created_at}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>