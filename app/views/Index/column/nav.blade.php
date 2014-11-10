  <div class="wrap-left">
      <div class="sort">
          <div class="sort-tit">全部分类</div>
          <div class="sort-bb"></div>
          <ul class="sort-list">
            @foreach($columns as $k => $column)
            <li
            @if( !empty($query['id']) && $query['id'] == $column->id)
            class="sort-act"
             @endif
             ><a href="/column?id={{$column->id}}&column_id={{$query['column_id']}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          @if (Session::get('utype') == 1)
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/uploadbank?column_id={{$query['column_id']}}">原创题库</a><div class="sort-sj"></div></div>
          @endif
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/training?column_id={{$query['column_id']}}">我的作业</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/favorite?column_id={{$query['column_id']}}">我的收藏</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/failTopic?column_id={{$query['column_id']}}">错题记录</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/message?column_id={{$query['column_id']}}">我的消息</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

          <!--
          <div class="sort-item sort-sd"><a href="/products?column_id={{$query['column_id']}}">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          -->
      </div>
  </div>