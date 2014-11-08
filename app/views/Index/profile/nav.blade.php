  <div class="wrap-left">
      <div class="sort">
          <div class="sort-bb"></div>
          <div class="avatar-box">
              <img src="{{Attachments::getAvatar(Session::get('uid'))}}" width="140" height="140" />
          </div>
          <div class="sort-bb"></div>
          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/column/static') sort-item-sel sort-nkm-sel @else sort-nkm @endif"><a href="/column/static">科目选择</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/favorite') sort-item-sel sort-nsc-sel @else sort-nsc @endif"><a href="/favorite">我的收藏</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/profile') sort-item-sel sort-ngr-sel @else sort-ngr @endif"><a href="/profile">个人资料</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/profile/passwd') sort-item-sel sort-npw-sel @else sort-npw @endif"><a href="/profile/passwd">密码管理</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>

          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/failTopic') sort-item-sel sort-nct-sel @else sort-nct @endif"><a href="/failTopic">错题记录</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>

          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/classes') sort-item-sel sort-nbj-sel @else sort-nbj @endif"><a href="/classes">我的班级</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>
          
          <div class="sort-item @if($_SERVER["REQUEST_URI"] == '/feedback') sort-item-sel sort-nwt-sel @else sort-nwt @endif"><a href="/feedback">问题反馈</a><div class="sort-nsj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>