@extends('Index.master')
@section('title')题目@stop

@extends('Index.column.columnHead')

@section('css')
    <link href="/assets/mediaelement/build/mediaelementplayer.min.css" rel="stylesheet">

    @if( !empty($_GET['vetting']) )
    <link href="/assets/layer/skin/layer.css" rel="stylesheet">
    @endif
@stop
@section('headjs')
    <script src="/assets/mediaelement/build/mediaelement-and-player.min.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/swfobject.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/recorder.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/main.js"></script>
    <script src="/assets/jquery/jquery.cookie.js"></script>

    @if( !empty($_GET['vetting']) )
    <script src="/assets/layer/layer.min.js"></script>
    @endif
@stop

@section('content')
    <div class="topic-head">
        <div class="wrap">
            @if(!empty($backurl))
            <a class="back" href="{{$backurl}}">< 返回</a>
            @endif
            @if($q['type'] == 8 || $q['type'] == 9 || $q['type'] == 10)
            <b>{{$q['txt'] or ''}}</b>
            @else
            <b>{{$headTitle or ''}}</b>
            @endif
            <div id="total_time">
                答题时间<span id="total_time_show"></span>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    {{-- 播放音频相关 --}}
    <div style="display:none;">
        <!-- 题干音 -->
        <audio class="playlist" id="q-sound" src="{{$q['sound_url'] or ''}}">
        <!-- 提示音 -->
        <audio class="playlist playloop" id="q-hint" src="{{$q['hint_url'] or ''}}">
        <!-- 参考音 -->
        <audio id="q-cky" src="{{$a[0]['sound_url'] or ''}}">
    </div>

    <div class="container wrap">
        <div class="topic-con" @if($q['type'] == 8 || $q['type'] == 9 || $q['type'] == 10): style="padding:0;" @endif >
            <div>
                @if( ($q['type'] != 8 && $q['type'] != 9 && $q['type'] != 10) && !empty($q['txt']) ) <h2 style="font-size:14px;">{{$index}}. {{$q['txt']}}</h2> @endif
                @if( ($q['type'] != 8 && $q['type'] != 9 && $q['type'] != 10) && !empty($q['img']) ) <div><img src= "{{$q['img_url']}}" /></div> @endif
            </div>

            {{-- 视唱,模唱 --}}
            @if( $q['type'] == 6 || $q['type'] == 7)
            {{-- 录音相关 --}}
            <div id="save_button">
                <span id="flashcontent">
                <!--
                  <p>Your browser must have JavaScript enabled and the Adobe Flash Player installed.</p>
                  -->
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
            @endif

            <div id="answers">
                    {{-- 单选，多选，判断 --}}
                    <?php $explain =""; ?>
                    @if( $q['type'] == 1 || $q['type'] == 2 || $q['type'] == 3 )
                        <table class="answers-list">
                        @if(!empty($a))
                        @foreach($a as $k => $item)
                            <tr>
                                <td class="flag">
                                    <label>
                                        @if( $q['type'] == 1 || $q['type'] == 3)
                                            <input type="radio" name="daan" value="{{$item['id']}}" is-right="{{$item['is_right']}}" onclick="correcting()" autocomplete="off" />
                                        @else
                                            <input type="checkbox" name="daan" value="{{$item['id']}}" is-right="{{$item['is_right']}}" autocomplete="off" />
                                        @endif

                                        @if($q['type'] != 3)
                                        <b>{{$flag[$k]}}.</b>
                                        <?php
                                            if(!empty($item['explain'])) 
                                                $explain .= $flag[$k] . '. ' . $item['explain'] . '<br/>';  
                                        ?>
                                        @endif

                                        <div class="flag-true"></div>
                                        <div class="flag-false"></div>
                                    </label>
                                </td>
                                <td>
                                    @if( !empty($item['img_url']) )
                                        <img src="{{$item['img_url']}}" />
                                    @elseif( !empty($item['sound_url']) )
                                        <button type="button" class="sound-play playlist playloop playbtn" sound-id="{{$item['sound_att_id']}}" src="{{$item['sound_url']}}" ></button>
                                        <span style="display:none;">
                                            <audio id="{{$item['sound_att_id']}}" src="{{$item['sound_url']}}" >
                                        </span>
                                    @elseif( !empty($item['txt']) )
                                        {{$item['txt']}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </table>
                    {{-- 模唱 --}}
                    @elseif( $q['type'] == 6 )
                    {{-- 视唱 --}}
                    @elseif( $q['type'] == 7 )
                        @if(!empty($a))
                        @foreach($a as $k => $item)
                            @if( !empty($item['img_url']) )
                                <div style="text-align:center;"><img src="{{$item['img_url']}}" /></div>
                            @endif
                        @endforeach
                        @endif
                    @elseif( $q['type'] == 8)
                       <div style="text-align:center;">
                         {{$a[0]['txt']}}
                         @if( !empty($_GET['vetting']) && !empty($q['img']) )
                         <div style="text-align:center;"><img src="{{$q['img_url']}}" /></div>
                         @endif
                       </div>
                    @elseif( $q['type'] == 9 || $q['type'] == 10 )
                      <div style="text-align:center;">
                        <embed src="{{$q['flash_url'] or ''}}" allowFullScreen="true" quality="high" width="850" height="500" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
                        @if( !empty($_GET['vetting']) && !empty($q['img']) )
                        <div><img src="{{$q['img_url']}}" /></div>
                        @endif
                      </div>
                    @endif 

            </div>


            @if( $q['type'] == 1 || $q['type'] == 2 || $q['type'] == 3 )        
            <div id="disabuse" class="disabuse-close">
                <div id="disabuse-box">
                    <div id="disabuse-tit">答案详解</div>
                    <div id="disabuse-con">
                        {{$q['disabuse']}}
                        <?php echo $explain; ?>
                    </div>
                </div>
                <div id="disabuse-flag" onclick="disabuse();"></div>
            </div>
            @endif

        </div>
        
        {{-- 填空，写作 --}}
        @if($q['type'] == 4 || $q['type'] == 5 )
        <div id="type-45" style="display:none;">
            <div><img src="/assets/img/topic-da.png" /></div>
            <div class="clear"></div>
            @if( !empty($q['disabuse']) )
                {{$q['disabuse']}}
            @endif
        </div>
        @endif
        
        {{-- 答题卡 --}}
        <div id="qlist" style="display:none;">
            @foreach($qlist as $k => $v)
                @if( ( empty($_GET['id']) && $k == 0 ) || ( !empty($_GET['id']) && $_GET['id'] == $v) )
                    <a style="background-color:#999999;color:#fff;" href='topic?uniqid={{$uniqid}}&id={{$v}}' class="" >{{$k+1}}</a>
                @elseif( !empty($_GET['id']) && !empty($trues[$v]) )
                    @if( $trues[$v] == 1 )
                        <a style="background-color:#1db5a9;color:#fff;" href='topic?uniqid={{$uniqid}}&id={{$v}}' class="" >{{$k+1}}</a>
                    @else
                        <a style="background-color:#ee2b27;color:#fff;" href='topic?uniqid={{$uniqid}}&id={{$v}}' class="" >{{$k+1}}</a>
                    @endif
                @else
                    <a href='topic?uniqid={{$uniqid}}&id={{$v}}' class="" >{{$k+1}}</a>
                @endif
            @endforeach
            <div class="clear"></div>
        </div>

        @if(!empty($from) && $from == 'favorite')
        <div id="topic-tools">
            <a class="topic-btn" id="topic-btn-2" hint="上一题" href="javascript:;" onclick="topicSubmit('prev');"></a>
            <a class="topic-btn" id="topic-btn-3" hint="下一题" href="javascript:;" onclick="topicSubmit('next');"></a>
            <div class="clear"></div>
        </div>
        @elseif(!empty($from) && $from == 'fail')
        {{--错题记录显示--}}
        <div id="topic-tools">
            <a class="topic-btn" id="topic-btn-2" hint="上一题" href="javascript:;" onclick="topicSubmit('prev');"></a>
            <a class="topic-btn" id="topic-btn-3" hint="下一题" href="javascript:;" onclick="topicSubmit('next');"></a>
            <a class="topic-btn" id="topic-btn-4" hint="收藏"  href="javascript:;" onclick="addFavorite({{$q['id']}},{{$column or '0'}});"></a>
            <div class="clear"></div>
        </div>
        @elseif( !empty('exam') )
        {{-- 如果是测试试卷 --}}
        <div id="topic-tools">
            @if( $q['type'] == 2)
            <a class="topic-btn" id="topic-btn-1" hint="提交" href="javascript:;" onclick="correcting();"></a>
            @endif
            @if( $q['type'] == 6 || $q['type'] == 7)
            <a class="topic-btn" id="topic-btn-10" hint="开始录音"  href="javascript:;" onclick="recorderStart();"></a>
            @endif
            <div class="clear"></div>
        </div>
        @elseif( $q['type'] != 8 && $q['type'] != 9 && $q['type'] != 10 )
        <div id="topic-tools">
            @if( $q['type'] == 2)
            <a class="topic-btn" id="topic-btn-1" hint="提交" href="javascript:;" onclick="correcting();"></a>
            @endif

            {{-- 试卷没有上一题，下一题和答题卡 --}}
            <a class="topic-btn" id="topic-btn-2" hint="上一题" href="javascript:;" onclick="topicSubmit('prev');"></a>
            <a class="topic-btn" id="topic-btn-3" hint="下一题" href="javascript:;" onclick="topicSubmit('next');"></a>

            {{-- 不是视唱或模唱 --}}
            @if( $q['type'] != 6 && $q['type'] != 7 )
                {{-- 如果有提示音或题目音 --}}
                @if( !empty($q['hint_url']) || !empty($a[0]['sound_url']))
                <a class="topic-btn" id="topic-btn-7" hint="再听一遍"  href="javascript:;" onclick="initPlay();"></a>
                @endif
            @endif

            @if( empty($_GET['vetting']) )
            <a class="topic-btn" id="topic-btn-4" hint="收藏"  href="javascript:;" onclick="addFavorite({{$q['id']}},{{$column or '0'}});"></a>
            @endif
            
            <a class="topic-btn" id="topic-btn-13" hint="取消收藏"  href="javascript:;" onclick="delFavorite({{$q['id']}},{{$column or '0'}});" style="display:none;"></a>
            @if( $q['type'] == 4 || $q['type'] == 5 )
                <a class="topic-btn" id="topic-btn-11" hint="显示答案"  href="javascript:;" onclick="showDaan();"></a>
                <a class="topic-btn" id="topic-btn-14" hint="隐藏答案"  href="javascript:;" onclick="hideDaan();" style="display:none;"></a>
            @endif

            @if( $q['type'] == 1 || $q['type'] == 2 || $q['type'] == 3 )
            <a class="topic-btn" id="topic-btn-5" hint="详解" href="javascript:;" onclick="disabuse();"></a>
            <div class="topic-btn" id="topic-btn-checkbox">
                <input type="checkbox" name="ashow" id="checkbox-1" onchange="topauto();" /> <label for="checkbox-1">答错后自动查看详解</label>
                <br>
                <input type="checkbox" name="ato" id="checkbox-2" onchange="topauto();" /> <label for="checkbox-2">答对后自动跳转到下一题</label>
            </div>
            @endif


            @if( $q['type'] == 6 || $q['type'] == 7 )
            <a class="topic-btn" id="topic-btn-7" hint="再听一遍"  href="javascript:;" onclick="loopPlay();"></a>
            <a class="topic-btn" id="topic-btn-9" hint="听参考音"  href="javascript:;" onclick="ckyPlay();"></a>
            <a class="topic-btn" id="topic-btn-10" hint="开始录音"  href="javascript:;" onclick="recorderStart();"></a>
            <a class="topic-btn" id="topic-btn-12" hint="停止录音"  href="javascript:;" onclick="recorderStop();" style="display:none;"></a>
            <a class="topic-btn" id="topic-btn-8" hint="录音回放"  href="javascript:;" onclick="recorderPlay();" style="display:none;"></a>
            <!--
            <a class="topic-btn" hint="开始"  href="javascript:;" onclick="recorderStart();">开始答题</a>
            -->
            @endif

            @if( !empty($_GET['vetting']) )
                <a class="topic-btn" id="topic-btn-15" href="javascript:;" onclick="vetting();">审核</a>
            @endif

            <a class="topic-btn" id="topic-btn-6" hint="显示答题卡" href="javascript:;" onclick="showList();"></a>
            <div class="clear"></div>
        </div>
        @elseif( !empty($_GET['vetting']) )
        <div id="topic-tools">
            <a class="topic-btn" id="topic-btn-15" href="javascript:;" onclick="vetting();">审核</a>
            <div class="clear"></div>
        </div>
        @else
        {{-- 视频，flash有上下题选择 --}}
        <!--
        <div id="topic-tools">
            <a class="topic-btn" id="topic-btn-2" hint="上一题" href="javascript:;" onclick="topicSubmit('prev');"></a>
            <a class="topic-btn" id="topic-btn-3" hint="下一题" href="javascript:;" onclick="topicSubmit('next');"></a>
            <a class="topic-btn" id="topic-btn-6" hint="显示答题卡" href="javascript:;" onclick="showList();"></a>
            
            <div class="clear"></div>
        </div>
        -->
        @endif


    </div> <!-- /container -->

    {{-- 自动播放音频列表 --}}

    @if( !empty($playList) )
    <div style="display:none;">
        <!-- 初始播放列表 -->
        <audio id="list-audio" src="{{$playList[0]['url'] or ''}}" />

        <ul id="play-list">
        @foreach($playList as $v)
            @if(!empty($v['time_spacing']))
            <li time-spacing="{{$v['time_spacing']}}"></li>
            @endif
            @if(!empty($v['url']))
            <li>{{$v['url']}}</li>
            @endif
        @endforeach
        </ul>
    </div>
    @endif

    {{-- 答题数据提交 --}}
    <form id="topicForm" name="topicForm" action="/topic/post" method="post">
      <input type="hidden" name="id" value="{{$q['id']}}">
      <input type="hidden" id="wavBase64" name="wavBase64" value="" >
      <input type="hidden" id="isTrue" name="isTrue" value="0" >
      <input type="hidden" id="result" name="answers" value="" >
      <input type="hidden" id="act" name="act" value="next">
      <input type="hidden" id="uniqid" name="uniqid" value="{{$uniqid or ''}}">
    </form>

    {{-- 审核表单 --}}
    <input type="hidden" name="vetting-qid" value="{{$q['id']}}" />
    <input type="hidden" id="vetting-status" name="vetting-status" value="1" />
    <input type="hidden" id="cause" name="cause" value="" />
    <div id="vetting-mode" style="display:none;">
        <div>
            <select class="tyinput" name="xstatus" style="width:400px;" onchange="document.getElementById('vetting-status').value=this.value;">
                <option value="1">审核通过</option>
                <option value="-1">审核未通过</option>
            </select>
        </div>
        <div id="vetting-cause">
            <div style="padding: 10px 0 0 10px;">未通过原因</div>
            <input type="text" class="tyinput" style="width:400px;" name="xcause" value=""  onchange="document.getElementById('vetting-cause').value=this.value;" />
        </div>
        <div style="text-align:center;">
            <button class="tyinput" onclick="doVetting();">提交审核</button>
        </div>
    </div>

    <script>
        $(document).ready(function(){

            $('.sound-play').click(function(){
                id = $(this).attr('sound-id');
                player = new MediaElementPlayer('#' + id, {
                    success: function (mediaElement, domObject) {
                        mediaElement.addEventListener('ended', function (e) {
                            $('.playbtn-current').each(function(){
                                $(this).removeClass('playbtn-current');
                            });
                        }, false);
                    }
                });
                player.pause();
                player.play();

                $(this).addClass('playbtn-current');
            });
    
            if( $.cookie('ashow') ==1)
                $("input[name=ashow]").prop("checked", true);

            if( $.cookie('ato') ==1)
                $("input[name=ato]").prop("checked", true);

            @if( !empty($total_time) )
            totalTime({{$total_time}});
            @endif

            // 延时2秒播放
            setTimeout(initPlay, 2000);
        });
        

        /* 总时间倒计时，自动跳转到下一题 */
        function totalTime(t)
        {
            $('#total_time').show();

            /* 时间用尽则跳转 */
            if(t < 0)
                topicSubmit('next');
            else
                $('#total_time_show').html(t);

            setTimeout(function(){ totalTime(--t); }, 1000);
        }

        /* 播放题干音和提示音 */
        var ip;
        function initPlay()
        {
            ip = new MediaElementPlayer('#list-audio', {
                success: function (mediaElement, domObject) {
                    mediaElement.addEventListener('ended', function (e) {
                        mejsPlayNext(e.target);
                    });

                    mediaElement.play();
                },
                error: function (e) {
                    console.log('MediaElementPlayer error: ' + e);
                },
                keyActions: []
            });
        }

        
        function mejsPlayNext(currentPlayer) 
        {
            if ($('#play-list li.current').length > 0)
            {
                var current_item = $('#play-list li.current:first');
                var next = $(current_item).next();

                // 如果是暂停
                if(next.attr('time-spacing'))
                {
                    $(current_item).next().addClass('current').siblings().removeClass('current');
                    setTimeout(function(){ mejsPlayNext(currentPlayer); }, next.attr('time-spacing') *1000);
                    console.log('spacing');
                    return;
                }
                else
                {
                    var audio_src = next.text();
                    $(current_item).next().addClass('current').siblings().removeClass('current');

                    setPlaybtn(audio_src);
                }
                console.log('if '+audio_src);
            }
            else
            {
                // if there is no .current class
                var current_item = $('#play-list li:first'); // get :first if we don't have .current class
                var audio_src = $(current_item).next().text();
                $(current_item).next().addClass('current').siblings().removeClass('current');

                setPlaybtn(audio_src);
                console.log('elseif '+audio_src);
            }

            // 如果当前是最后一个
            if( $(current_item).is(':last-child') ) 
            { 
                $(current_item).removeClass('current');

                //setTimeout(function(){ mejsPlayNext(currentPlayer); }, next.attr('time-spacing') *1000);
            }
            else if(audio_src)
            {
                currentPlayer.setSrc(audio_src);
                currentPlayer.play();
            }
        }

        // 设置播放时图标
        function setPlaybtn(src)
        {
            $('.playbtn-current').each(function(){
                $(this).removeClass('playbtn-current');
            });
            $('.playbtn').each(function(){
                if( $(this).attr('src') == src )
                {
                    $(this).addClass('playbtn-current');
                }
            });
        }
 

        /* 手动点击重复播放 */
        function loopPlay()
        {
            var list = getLoopList();
            if(list.length > 0)
            {
                $('#play-list').attr('src', list[0]);
                try
                {
                    ip.play();
                }
                catch (e)
                {
                    console.log("loop play fail");
                }
            }
        }

        /* 获取重复播放列表 */
        function getLoopList()
        {
            var list = new Array();
            $('.playloop').each(function(){
                if($(this).attr('src') != '')
                {
                    list.push( $(this).attr('src') );
                }
            });

            return list;
        }

        var hp;
        function hintPlay()
        {
            hp = new MediaElementPlayer('#q-hint');
            hp.play();
        }

        var sp;
        function soundPlay()
        {
            sp = new MediaElementPlayer('#q-sound');
            sp.play();
        }

        /* 参考音 */
        function ckyPlay()
        {
            player = new MediaElementPlayer('#q-cky');
            player.play();
        }

        function topauto()
        {
             if( $("input[name=ashow]").is(':checked') )
                $.cookie('ashow', '1', { expires: 365, path: '/' });
            else
                $.cookie('ashow', '0', { expires: 365, path: '/' });

            if( $("input[name=ato]").is(':checked') )
                $.cookie('ato', '1', { expires: 365, path: '/' });
            else
                $.cookie('ato', '0', { expires: 365, path: '/' });
        }

        // js 判断答题对错
        function correcting()
        {
            try {
                if(ip) ip.pause();
            } catch(error) {
                console.log(error);
            }
            try {
                if(hp) hp.pause();
            } catch(error) {
                console.log(error);
            }
            
            try {
                if(sp) sp.pause();
            } catch(error) {
                console.log(error);
            }

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

            $('input[name=daan]').each(function(){
                console.log("disabled");
                $(this).attr("disabled", "disabled");
            });

            if(err.length > 0)
            {
                console.log(err);
                $('#isTrue').val('-1');

                if( $("input[name=ashow]").is(':checked') )
                {
                    disabuse();
                }
            }
            else
            {
                console.log('all right!');
                $('#isTrue').val('1');

                if( $("input[name=ato]").is(':checked') )
                {
                    $('#act').val('next');
                    $('#topicForm').submit();
                }
            }
        }

        function topicSubmit(act)
        {
            correcting();
            $('#act').val(act);
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
            FWRecorder.record('audio', 'audio.wav');
        }

        function recorderStop()
        {
            $('#topic-btn-10').show();
            $('#topic-btn-12').hide();
            $('#topic-btn-8').show();
            FWRecorder.stopRecording('audio');
        }

        function autoRecorderStop()
        {
            $('#topic-btn-10').show();
            $('#topic-btn-12').hide();
            $('#topic-btn-8').show();
        }

        function recorderPlay()
        {
            FWRecorder.playBack('audio');
        }

        function showList()
        {
            /*计算题目列表定位高度*/
            h = $('#qlist').height() + 10;
            $('#qlist').css('bottom', h);
            $('#qlist').toggle();
        }

        function addFavorite(qid, column)
        {
            $.getJSON("/favorite/ajax", {'act':'add','qid':qid,'column':column}, function(data){
                 if(data.state == 1)
                 {
                    $('#topic-btn-4').hide();
                    $('#topic-btn-13').show();
                 }
            });
        }

        function delFavorite(qid, column)
        {
            $.getJSON("/favorite/ajax", {'act':'del','qid':qid,'column':column}, function(data){
                if(data.state == 1)
                {
                    $('#topic-btn-4').show();
                    $('#topic-btn-13').hide();

                }
            });
        }

        function showDaan()
        {
            $('#type-45').show();
            $('#topic-btn-11').hide();
            $('#topic-btn-14').show();
        }
        function hideDaan()
        {
            $('#type-45').hide();
            $('#topic-btn-11').show();
            $('#topic-btn-14').hide();
        }

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

        function doVetting()
        {
            $.post("/admin/relation/do_question",
            {
              question_id: $("input[name=vetting-qid]").val(),
              status: $("#vetting-status").val(),
              cause: $("#vetting-cause").val()
            },
            function(data) {
                layer.closeAll();

                if(data.status == 1)
                {
                    var i = $.layer({
                        type : 0,
                        title : " ",
                        shadeClose: true,
                        shade: [0],
                        dialog: {
                            type: -1,
                            msg: '审核成功'
                        }
                    });
                }
                else
                {
                    var i = $.layer({
                        type : 0,
                        title : " ",
                        shadeClose: true,
                        shade: [0],
                        dialog: {
                            type: -1,
                            msg: '审核失败'
                        }
                    });
                }
            },
            "json"
          )
          .fail(function(){
              var i = $.layer({
                        type : 0,
                        title : " ",
                        shadeClose: true,
                        shade: [0],
                        dialog: {
                            type: -1,
                            msg: '审核失败'
                        }
                    });
          });
        }
    </script>

@stop

