@extends('Index.master')
@section('title')科目选择 @stop

@section('headjs')
<script src="/assets/layer/layer.min.js"></script>
@stop

<style>
  .gonggao{
    width:500px;
    height:450px;
    overflow-y:auto;
    padding:10px;
  }
</style>

@section('content')
<div class="container-column wrap">

  <div style="margin:50px 0;">
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">

        <tr >
            <td style="padding:10px;">
                <a href="/column?column_id=3"><img src="/assets/img/index-a3.png" /></a>
            </td>

            <td style="padding:10px;">
                <a href="/column?column_id=4"><img src="/assets/img/index-a2.png" /></a>
            </td>

            <td style="padding:10px;">
                <a href="/column?column_id=5"><img src="/assets/img/index-a1.png" /></a>
            </td>
        </tr>

        </table>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->


<div id="vetting-mode" style="display:none;">
    <div class="gonggao">
    <p>您在{{$bDay}}天后将被降级为学生用户，没有教师特权，但不影响您使用！</p>
    <p>&nbsp;</p>
    <h3>一、我已经是老师了，会不会被降级？</h3>
    <p>注册后1个月内未达到以下目标：</p>
    <p>1、未建立班级；</p>
    <p>2、已经建立班级，班级用户总计少于{{$minMate}}人；</p>
    <p>&nbsp;</p>
    <h3>二、测评平台里，老师目前以及未来有什么特权？</h3>
    <p>1、老师可以创建班级；</p>
    <p>2、老师可以浏览全部题库，学生浏览部分题库；</p>
    <p>3、老师可以从题库中选题，组卷、留作业；</p>
    <p>4、老师可以查看学生作业情况，包括得分、以及错题； </p>
    <p>5、老师未来可以进行资源下载；【终身免费老师，免费下载】 </p>
    <p>6、老师可以组织班级才艺展示，可以推荐学生参加未来艺术活动比赛； </p>
    <p>7、老师可以留唱歌等PK练习；</p>
    <p>&nbsp;</p>
    <h3>三、如何成为终身免费用户？</h3>
    <p>1. 建立2个以上班级，每个班级加入学生在30人以上；</p>
    <p>2. 利用学校多媒体教室，学生登录使用音基360音乐测评平台；或完成老师在测试平台所留作业或练习；</p>
    <p>3. 邀请4位或4位以上音乐教师加入使用，他们注册时候邀请人写你的名字；<span style="color:red;">（需要将四位老师的申请表整理发送37716890@qq.com)</span></p>
    </div>
</div>

<script type="text/javascript">
  function vetting()
  {
      var i = $.layer({
          type : 1,
          title : false,
          shadeClose: true,
          offset:['100px' , ''],
          shade: [0],
          area : ['auto','auto'],
          page : {
              html: $("#vetting-mode").html()
          }
      });
  }

  @if($isBulletin)
  vetting();
  @endif

</script>

@stop

