<ul class="nav nav-list">
  <li>{{ link_to_route('admin.column.index', ' 科目管理', array(), array('class' => 'icon-list')) }}</li>
  @if (isset($query['parent_id']))
  <li>{{ link_to_route('admin.column.create', ' 新建科目', array('parent_id' => $query['parent_id']), array('class' => 'icon-list')) }}</li>
  @else
  <li>{{ link_to_route('admin.column.create', ' 新建科目', array('parent_id' => 0), array('class' => 'icon-list')) }}</li>
  @endif
</ul>