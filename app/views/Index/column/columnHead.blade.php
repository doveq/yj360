@if(!empty($columnHead))
@section('columnHead')
  <div id="column-head">| <b>{{$columnHead['name']}}</b>
      <div id="column-head-list">
        <div id="chl-jt"><img src="/assets/img/chl-jt.png" /></div>
        <a href="/column?column_id=5"><img src="/assets/img/chl-1.png" /></a>
        <a href="/column?column_id=4" style="margin-left:7px;"><img src="/assets/img/chl-2.png" /></a>
        <a href="/column?column_id=3" style="margin-top:5px;"><img src="/assets/img/chl-3.png" /></a>
      </div>
  </div>
@stop
@endif
