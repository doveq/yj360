<div class="form-group">
	<label class="col-sm-2 control-label">题型选择</label>
    <div class="col-sm-10">
      	<select name="selTyep" onchange="window.location.href='/admin/topic/add?type='+ this.value">
      		<option value="1" @if($_GET['type'] ==1) selected="selected" @endif >单选题</option>
      		<option value="2" @if($_GET['type'] ==2) selected="selected" @endif >多选择题</option>
      		<option value="3" @if($_GET['type'] ==3) selected="selected" @endif >判断题</option>
      		<option value="4" @if($_GET['type'] ==4) selected="selected" @endif >填空题</option>
      		<option value="5" @if($_GET['type'] ==5) selected="selected" @endif >写作题</option>
      		<option value="6" @if($_GET['type'] ==6) selected="selected" @endif >模唱</option>
      		<option value="7" @if($_GET['type'] ==7) selected="selected" @endif >视唱</option>
      		<option value="8" @if($_GET['type'] ==8) selected="selected" @endif >视频</option>
      		<option value="9" @if($_GET['type'] ==9) selected="selected" @endif >教材</option>
      		<option value="10" @if($_GET['type'] ==10) selected="selected" @endif >游戏</option>
      	</select>
    </div>
</div>