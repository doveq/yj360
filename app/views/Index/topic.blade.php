@extends('Index.master')
@section('title')题目@stop

@section('css')
    <link href="/assets/mediaelement/build/mediaelementplayer.min.css" rel="stylesheet">
@stop
@section('headjs')
    <script src="/assets/mediaelement/build/mediaelement-and-player.min.js"></script>
@stop

@section('content')
    <div class="container wrap">
        <div>
            @if( !empty($q['txt']) ) <h2>{{$q['txt']}}</h2> @endif
            @if( !empty($q['img']) ) <div><img src= "{{$q['img_url']}}" /></div> @endif
        </div>

        <div>
            @if( !empty($a) )
                <ul class="answers-list">
                @foreach($a as $item)
                    @if( !empty($item['img_url']) )
                        <li><img src="{{$item['img_url']}}" /></li>
                    @elseif( !empty($item['sound_url']) )
                        <li><button type="button" onclick="" >播放</button></li>
                    @endif
                @endforeach
                </ul>
            @endif    
        </div>

        <br><br>
        
        <div id="topic-tools">
            <a class="topic-btn" id="topic-btn-1" hint="提交" href="#"></a>
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

    <div style="display:none;">
        <!-- 题干音 -->
        <audio id="q_sound" src="{{$q['sound_url'] or ''}}">
        <!-- 提示音 -->
        <audio id="q_hint" src="{{$q['hint_url'] or ''}}">

        <audio id="aplay" src="">
    </div>

    <script>
        @if(!empty($q['sound_url']))
        {
            var q_sound = true;
        }
        @elseif(!empty($q['hint_url']))
        {
            var q_hint = true;
        }
        @endif
        
        function aplay($url)
        {
            var player = new MediaElementPlayer('#aplay');
            player.setSrc($url);
            player.play();
        }
        
        $(document).ready(function(){
            if(q_sound)
            {
                var player = new MediaElementPlayer('#q_sound');
                player.play();  
            }
        });

    </script>

@stop

