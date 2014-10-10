<ul class="nav nav-list">
  <li>{{ link_to_route('admin.subject.index', ' 科目管理', array(), array('class' => 'icon-list')) }}</li>
  <li class="divider"></li>
  @foreach($subject_contents as $item)
  <li><a href="{{ url('/admin/content_exam?subject_content_id=' . $item->id) }}" class="icon-caret-right"> {{$item->name}}</a></li>
  @endforeach
</ul>
