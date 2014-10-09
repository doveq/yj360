@extends('Index.master')
@section('title')题目@stop

@section('content')
    <div class="container wrap">
        <div>
            <h3>{{$q['txt']}}</h3>
        </div>
        <br><br>
        
        <div id="topic-tools">
            <a class="topic-btn" id="topic-btn-1" hint="提交" href="#">提交</a>
            <a class="topic-btn" id="topic-btn-2" hint="上一题" href="#"></a>
            <a class="topic-btn" id="topic-btn-3" hint="下一题" href="#"></a>
            <a class="topic-btn" id="topic-btn-4" hint="收藏" href="#"></a>
            <a class="topic-btn" id="topic-btn-5" hint="详解" href="#"></a>
            <div class="topic-btn" id="topic-btn-checkbox">
                <input type="checkbox" name="sex" id="checkbox-1" /> <label for="checkbox-1">答错后自动查看详解</label>
                <br>
                <input type="checkbox" name="sex" id="checkbox-2" /> <label for="checkbox-2">答对后自动跳转到下一题</label>
            </div>
            <a class="topic-btn" id="topic-btn-6" hint="答题卡" href="#"></a>
            <div class="clear"></div>
        </div>

    </div> <!-- /container -->
@stop