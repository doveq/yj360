  <div class="wrap-left">
      <div class="sort fav-nav">
          <div class="sort-item @if($query['type']==4) select @endif"><a href="/feedback">问题反馈</a><div class="sort-sj"></div></div>
          <div class="sort-item @if($query['type']==1) select @endif"><a href="/notice/list?column_id={{$query['column_id']}}&type=1">帮助手册</a><div class="sort-sj"></div></div>
          <div class="sort-item @if($query['type']==2) select @endif"><a href="/notice/list?column_id={{$query['column_id']}}&type=2">升级公告</a><div class="sort-sj"></div></div>
          <div class="sort-item @if($query['type']==3) select @endif"><a href="/notice/list?column_id={{$query['column_id']}}&type=3">360&nbsp;活动</a><div class="sort-sj"></div></div>
      </div>
  </div>
  