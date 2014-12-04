@extends('Index.master')
@section('title')科目选择 @stop

@section('headjs')
<script src="/assets/layer/layer.min.js"></script>
@stop

<style>
  .gonggao{
    width:602px;
    height:405px;
    overflow-y:auto;
    position:relative;
  }
  #ggaoday{
    position:absolute;
    color: red;
    color: red;
    font-size: 30px;
    left: 178px;
    position: absolute;
    top: 22px;
    width: 40px;
    text-align: center;
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
      <div id="ggaoday">{{$bDay}}</div>
      <img src="/assets/img/tnotebg.png" />
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
          border: [0],
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

