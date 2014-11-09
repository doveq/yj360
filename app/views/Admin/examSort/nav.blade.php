<ul class="nav nav-list">
  <li>{{ link_to_route('admin.examSort.index', ' 试卷分类管理', array(), array('class' => 'icon-list')) }}</li>
  @if (isset($query['parent_id']))
  <li>{{ link_to_route('admin.examSort.create', ' 新建分类', array('parent_id' => $query['parent_id']), array('class' => 'icon-list')) }}</li>
  @else
  <li>{{ link_to_route('admin.examSort.create', ' 新建分类', array('parent_id' => 0), array('class' => 'icon-list')) }}</li>
  @endif
</ul>