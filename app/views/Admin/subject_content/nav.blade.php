<ul class="nav nav-list">
  <li>{{ link_to_route('admin.subject.index', ' 科目管理', array(), array('class' => 'icon-list')) }}</li>
  <li>{{ link_to_route('admin.subject.index', ' ' .$subject->name, array(), array('class' => 'icon-edit')) }}</li>
  <li class="divider"></li>
  @foreach($items as $item)
  <li><a href="#" class="icon-caret-right"> {{$item->name}}</a></li>
  @endforeach
</ul>
