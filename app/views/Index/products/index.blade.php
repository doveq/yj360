@extends('Index.master')
@section('title')原创题库 @stop

@section('content')
<div class="container-column wrap">
  <div class="wrap-left">
      <div class="sort">
          <div class="sort-tit">全部分类</div>
          <div class="sort-bb"></div>
          <ul class="sort-list">
            @foreach($columns as $k => $column)
            <li><a href="/column?id={{$column->id}}&column_id={{$query['column_id']}}">{{$column->name}}</a><div class="sort-sj"></div></li>
            @endforeach
          </ul>
          @if (Session::get('utype') == 1)
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/uploadbank?column_id={{$query['column_id']}}">原创题库</a><div class="sort-sj"></div></div>
          @endif
          <div class="sort-bb"></div>
          <div class="sort-item sort-wbj"><a href="/classes?column_id={{$query['column_id']}}">我的班级</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>
          <div class="sort-item sort-sd sort-wbj-act"><a href="/products?column_id={{$query['column_id']}}">产品商店</a><div class="sort-sj"></div></div>
          <div class="sort-bb"></div>

      </div>
  </div>

  <div class="wrap-right">
    <div class="tabtool">
产品商店
    </div>
    <div class="product-list">
      @foreach($lists as $list)
        <div class="product-box">
          <div class="product-txt">
            <h2><b>{{$list->name}}</b></h2>
          </div>
          <div class="product-txt">
            <h2><b>￥{{$list->price}}</b></h2>
          </div>
          <div style="text-align:right;">
            <span class="product-buy">立即购买</span>
          </div>
        </div>
      @endforeach
    </div>
 </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
  delete_uploadbank = function(id){
    if(confirm('您确定要删除吗？')){
      $.ajax({
        url:'/uploadbank/'+id,
        // async:false,
        type:'delete',
      })
      .fail(function(){alert('操作失败')})
      .success(function(){
        $('#bank_'+id).remove();
      });
      // alert(htmlobj.responseText);
    }
  }

});
</script>
@stop


