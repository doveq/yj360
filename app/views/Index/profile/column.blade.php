@extends('Index.master')
@section('title')科目选择 @stop

@section('content')
<div class="container-column wrap">

  <div style="margin:20px;padding:50px">
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">

        <tr >
            <td style="padding:10px;">
                <a href="/column?column_id=3"><img src="/assets/img/static-k1.png" /></a>
            </td>

            <td style="padding:10px;">
                <a href="/column?column_id=4"><img src="/assets/img/static-k2.png" /></a>
            </td>

            <td style="padding:10px;">
                <a href="/column?column_id=5"><img src="/assets/img/static-k3.png" /></a>
            </td>
        </tr>

        </table>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

