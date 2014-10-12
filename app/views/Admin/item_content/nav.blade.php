<ul class="nav nav-list">
  <li>{{ link_to_route('admin.subject.index', ' 科目管理', array(), array('class' => 'icon-list')) }}</li>
  <li class="divider"></li>
  @foreach($subjects as $item)
  <li>{{link_to_route('admin.item_content.index',$item->name, array('subject_id' => $item->id))}}</li>
  @endforeach
</ul>