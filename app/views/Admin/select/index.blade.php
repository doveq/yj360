@extends('Admin.master_column')
@section('title')测试@stop

@section('content')
  <div class="row">
    <div id="column">
        {{Form::select('column1', array(), '', array('class' => 'column1'))}}
    {{Form::select('column2', array(), '', array('class' => 'column2'))}}
    {{Form::select('column3', array(), '', array('class' => 'column3'))}}
    {{Form::select('column4', array(), '', array('class' => 'column4'))}}
    {{Form::select('column5', array(), '', array('class' => 'column5'))}}
    </div>
  </div>
@stop

@section('js')
{{ HTML::script('/assets/jquery.cxselect.min.js') }}
<script type="text/javascript">

$(function(){
  // http://code.ciaoca.com/jquery/cxselect/
  // $.cxSelect.defaults.url = '/admin/column.json';
  $('#column').cxSelect({
      url:'/admin/column.json',
      required: 'true',
      selects: ['column1', 'column2', 'column3', 'column4', 'column5'],
      nodata: 'none'
  });
});
</script>
@stop