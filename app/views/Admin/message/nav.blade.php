<ul class="nav nav-list">
  <li>{{ link_to_route('admin.message.index', ' 站点消息', array(), array('class' => 'icon-list')) }}</li>
  <li>{{ link_to_route('admin.message.index', ' 私人消息', array('type' => 1), array('class' => 'icon-envelope')) }}</li>
  <li>{{ link_to_route('admin.message.index', ' 公共消息', array('type'=> 0), array('class' => 'icon-envelope-alt')) }}</li>
  <li>{{ link_to_route('admin.message.create', ' 发送消息', array(), array('class' => 'icon-edit')) }}</li>
</ul>