<ul class="nav nav-list">
  <li>科目功能项</li>
  <li class="divider"></li>
  @foreach($items as $item)
  <li><a href="/admin/item_content?subject_id={{$query['subject_id']}}&subject_item_id={{$item->id}}" class="icon-caret-right"> {{$item->name}}</a></li>
  @endforeach
</ul>