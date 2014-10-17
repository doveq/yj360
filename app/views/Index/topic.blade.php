@extends('Index.master')
@section('title')题目@stop

@section('css')
    <link href="/assets/mediaelement/build/mediaelementplayer.min.css" rel="stylesheet">
@stop
@section('headjs')
    <script src="/assets/mediaelement/build/mediaelement-and-player.min.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/swfobject.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/recorder.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/main.js"></script>
@stop

@section('content')
    <div class="container wrap">
        <div style="position:relative;overflow:hidden;">
            <div style="padding-bottom:20px;">
                @if( !empty($q['txt']) ) <h2>{{$q['txt']}}</h2> @endif
                @if( !empty($q['img']) ) <div><img src= "{{$q['img_url']}}" /></div> @endif
            </div>

            <div id="answers">
                @if( !empty($a) )
                    {{-- 单选，多选，判断 --}}
                    @if( $q['type'] == 1 || $q['type'] == 2 || $q['type'] == 3 )
                        <table class="answers-list">
                        @foreach($a as $k => $item)
                            <tr>
                                <td class="flag">
                                    <label>
                                        @if( $q['type'] == 1 || $q['type'] == 3)
                                            <input type="radio" name="daan" value="{{$item['id']}}" is-right="{{$item['is_right']}}" onclick="correcting()" />
                                        @else
                                            <input type="checkbox" name="daan" value="{{$item['id']}}" is-right="{{$item['is_right']}}" />
                                        @endif

                                        <b>{{$flag[$k]}}.</b>

                                        <div class="flag-true"></div>
                                        <div class="flag-false"></div>
                                    </label>
                                </td>
                                <td>
                                    @if( !empty($item['img_url']) )
                                        <img src="{{$item['img_url']}}" />
                                    @elseif( !empty($item['sound_url']) )
                                        <button type="button" class="sound-play" sound-id="{{$item['sound_att_id']}}" >播放</button>
                                        <span style="display:none;">
                                            <audio id="{{$item['sound_att_id']}}" src="{{$item['sound_url']}}">
                                        </span>
                                    @elseif( !empty($item['txt']) )
                                        {{$item['txt']}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    {{-- 填空，写作 --}}
                    @elseif($q['type'] == 4 || $q['type'] == 5 )
                    <div >
                        @foreach($a as $k => $item)
                            @if( !empty($item['txt']) )
                                <div>{{$item['txt']}}</div>
                            @elseif( !empty($item['img_url']) )
                                <div><img src="{{$item['img_url']}}" /></div>
                            @elseif( !empty($item['sound_url']) )
                                <div><audio src="$item['sound_url']"></div>
                            @endif
                        @endforeach
                    </div>
                    {{-- 模唱 --}}
                    @elseif( $q['type'] == 6 )
                    {{-- 视唱 --}}
                    @elseif( $q['type'] == 7 ) 
                        @foreach($a as $k => $item)
                            @if( !empty($item['img_url']) )
                                <img src="{{$item['img_url']}}" />
                            @endif
                        @endforeach
                    @endif 

                    

                @endif 
            </div>

            @if( $q['type'] == 1 || $q['type'] == 2 || $q['type'] == 3 )        
            <div id="disabuse" class="disabuse-close">
                <div id="disabuse-box">
                    <div id="disabuse-tit">答案详解</div>
                    <div id="disabuse-con">
                        {{$q['disabuse']}}
                    </div>
                </div>
                <div id="disabuse-flag" onclick="disabuse();"></div>
            </div>
            @endif

        </div>
        
        {{-- 录音相关 --}}
        <div id="save_button">
            <span id="flashcontent">
              <p>Your browser must have JavaScript enabled and the Adobe Flash Player installed.</p>
            </span>
        </div>
        <div style="display:none;">
            <div id="recorder-audio" class="control_panel idle">
                <button class="record_button" onclick="FWRecorder.record('audio', 'audio.wav');" title="Record">
                    <img src="/assets/recorder/images/record.png" alt="Record"/>
                </button>
                <button class="stop_recording_button" onclick="FWRecorder.stopRecording('audio');" title="Stop Recording">
                    <img src="/assets/recorder/images/stop.png" alt="Stop Recording"/>
                </button>
                <button class="play_button" onclick="FWRecorder.playBack('audio');" title="Play">
                    <img src="/assets/recorder/images/play.png" alt="Play"/>
                </button>
                <button class="pause_playing_button" onclick="FWRecorder.pausePlayBack('audio');" title="Pause Playing">
                    <img src="/assets/recorder/images/pause.png" alt="Pause Playing"/>
                </button>
                <button class="stop_playing_button" onclick="FWRecorder.stopPlayBack();" title="Stop Playing">
                    <img src="/assets/recorder/images/stop.png" alt="Stop Playing"/>
                </button>
                <div class="level"></div>
            </div>
            <div class="details" >
              <button class="show_level" onclick="FWRecorder.observeLevel();">Show Level</button>
              <button class="hide_level" onclick="FWRecorder.stopObservingLevel();" style="display: none;">Hide Level</button>
              
              
              <div><button class="show_settings" onclick="microphonePermission()">Microphone permission</button></div>
              <div id="status">
               Recorder Status...
              </div>
              <div>Duration: <span id="duration"></span></div>
              <div>Activity Level: <span id="activity_level"></span></div>
              <div>Upload status: <span id="upload_status"></span></div>
            </div>

            

            <form id="uploadForm" name="uploadForm" action="/recorder/upload">
              <input name="authenticity_token" value="" type="hidden">
              <input name="format" value="json" type="hidden">
            </form>
        </div>

        <div id="topic-tools">
            @if( $q['type'] == 2)
            <a class="topic-btn" id="topic-btn-1" hint="提交" href="javascript:;" onclick="correcting();"></a>
            @endif
            <a class="topic-btn" id="topic-btn-2" hint="上一题" href="javascript:;" onclick="topicSubmit();"></a>
            <a class="topic-btn" id="topic-btn-3" hint="下一题" href="javascript:;" onclick="topicSubmit();"></a>
            <a class="topic-btn" id="topic-btn-4" hint="收藏"  href="javascript:;"></a>
            @if( $q['type'] == 4 || $q['type'] == 5 )
                <a class="topic-btn" id="topic-btn-11" hint="显示答案"  href="javascript:;"></a>
            @endif

            @if( $q['type'] == 1 || $q['type'] == 2 || $q['type'] == 3 )
            <a class="topic-btn" id="topic-btn-5" hint="详解" href="javascript:;" onclick="disabuse();"></a>
            <div class="topic-btn" id="topic-btn-checkbox">
                <input type="checkbox" name="sex" id="checkbox-1" /> <label for="checkbox-1">答错后自动查看详解</label>
                <br>
                <input type="checkbox" name="sex" id="checkbox-2" /> <label for="checkbox-2">答对后自动跳转到下一题</label>
            </div>
            @endif
            @if( $q['type'] == 6 )
            <!--
            <a class="topic-btn" id="topic-btn-7" hint="再听一遍"  href="#"></a>
            <a class="topic-btn" id="topic-btn-9" hint="听参考音"  href="javascript:;" onclick="soundPlay();"></a>
            -->
            <a class="topic-btn" id="topic-btn-10" hint="开始录音"  href="javascript:;" onclick="recorderStart();"></a>
            <a class="topic-btn" id="topic-btn-12" hint="停止录音"  href="javascript:;" onclick="recorderStop();" style="display:none;"></a>
            <a class="topic-btn" id="topic-btn-8" hint="录音回放"  href="javascript:;" onclick="recorderPlay();" style="display:none;"></a>
            @endif
            <a class="topic-btn" id="topic-btn-6" hint="答题卡" href="#"></a>
            <div class="clear"></div>
        </div>

        <div class="qlist">
            @foreach($qlist as $v)
                <a href='tipic?column={{$column}}&id={{$v}}' class="" >{{$v}}</a>
            @endforeach
        </div>

    </div> <!-- /container -->

    {{-- 播放音频相关 --}}
    <div style="display:none;">
        <!-- 初始播放列表 -->
        <audio id="init-play" src="">
        <!-- 题干音 -->
        <audio id="q-sound" src="{{$q['sound_url'] or ''}}">
        <!-- 提示音 -->
        <audio id="q-hint" src="{{$q['hint_url'] or ''}}">
    </div>

    {{-- 答题数据提交 --}}
    <form id="topicForm" name="topicForm" action="/topic/post" method="post">
      <input type="hidden" name="id" value="{{$q['id']}}">
      <input type="hidden" id="wavBase64" name="wavBase64" value="" >
      <input type="hidden" id="isTrue" name="isTrue" value="0" >
    </form>

    <script>

        $(document).ready(function(){

            $('.sound-play').click(function(){
                id = $(this).attr('sound-id');
                player = new MediaElementPlayer('#' + id);
                player.pause();
                player.play();
            });

            initPlay();

        });

        // 播放题干音和提示音
        function initPlay()
        {
            new MediaElementPlayer('#q-hint', {
                success: function (mediaElement, domObject) {
                    mediaElement.addEventListener('ended', function(e) {
                        soundPlay();
                    }, false);
                     
                    mediaElement.play();
                }
            });
        }

        function hintPlay()
        {
            player = new MediaElementPlayer('#q-hint');
            player.play();
        }

        function soundPlay()
        {
            player = new MediaElementPlayer('#q-sound');
            player.play();
        }

        // js 判断答题对错
        function correcting()
        {
            var err = new Array();
            var result = '';
            $('input[name=daan]').each(function(){
                is_right = $(this).attr('is-right');

                if( $(this).is(':checked') )
                {
                    result += $(this).val() +',';

                    if(is_right == 0)
                    {
                        err.push( $(this).val() );
                        $(this).parent('label').addClass('correcting-false');
                    }
                }
                else if(is_right == 1)
                {
                    err.push( $(this).val() );
                    $(this).parent('label').addClass('correcting-false');
                }

                if(is_right == 1)
                {
                    $(this).parent('label').removeClass('correcting-false');
                    $(this).parent('label').addClass('correcting-true');
                }

            });


            $('#result').val(result);

            if(err.length > 0)
            {
                console.log(err);
                $('#isTrue').val('0');
            }
            else
            {
                console.log('all right!');
                $('#isTrue').val('1');
            }
        }

        function topicSubmit()
        {
            correcting();
            $('#topicForm').submit();
        }

        function disabuse()
        {
            obj = $('#disabuse');
            if(obj.data.show == 1)
            {
                obj.removeClass('disabuse-open');
                obj.addClass('disabuse-close');
                obj.data.show = 0;
            }
            else
            {
                obj.removeClass('disabuse-close');
                obj.addClass('disabuse-open');
                obj.data.show = 1;
            }
        }

        function recorderStart()
        {
            $('#topic-btn-10').hide();
            $('#topic-btn-12').show();
            $('#topic-btn-8').hide();
            FWRecorder.record('audio', 'audio.wav');
        }

        function recorderStop()
        {
            $('#topic-btn-10').show();
            $('#topic-btn-12').hide();
            $('#topic-btn-8').show();
            FWRecorder.stopRecording('audio');
        }

        function recorderPlay()
        {
            FWRecorder.playBack('audio');
        }
    </script>

@stop

