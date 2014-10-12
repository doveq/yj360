<ul class="nav nav-list">
  <li>{{ link_to_route('admin.classes.index', ' 班级管理', array(), array('class' => 'icon-list')) }}</li>
  <li>{{ link_to_route('admin.classmate.create', ' 邀请学生', array('class_id'=>$classes->id), array('class' => 'icon-plus-sign-alt')) }}</li>
</ul>
