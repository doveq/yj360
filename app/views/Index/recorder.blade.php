@extends('Index.master')
@section('title')flash录音@stop

@section('css')
    <link rel="stylesheet" href="/assets/recorder/style.css">
@stop

@section('js')
    <script type="text/javascript" src="/assets/recorder/js/swfobject.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/recorder.js"></script>
    <script type="text/javascript" src="/assets/recorder/js/main.js"></script>
@stop

@section('content')
    <div class="container">

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

        <div class="details">
          <button class="show_level" onclick="FWRecorder.observeLevel();">Show Level</button>
          <button class="hide_level" onclick="FWRecorder.stopObservingLevel();" style="display: none;">Hide Level</button>
          <span id="save_button">
            <span id="flashcontent">
              <p>Your browser must have JavaScript enabled and the Adobe Flash Player installed.</p>
            </span>
          </span>
          <div><button class="show_settings" onclick="microphonePermission()">Microphone permission</button></div>
          <div id="status">
           Recorder Status...
          </div>
          <div>Duration: <span id="duration"></span></div>
          <div>Activity Level: <span id="activity_level"></span></div>
          <div>Upload status: <span id="upload_status"></span></div>
        </div>

        <form id="uploadForm" name="uploadForm" action="/recorder/upload">
          <input name="authenticity_token" value="xxxxx" type="hidden">
          <input name="format" value="json" type="hidden">
        </form>

    <!--  配置参数，注释删除
    <h4>Configure Microphone</h4>
    <form class="mic_config" onsubmit="return false;">
      <ul>
        <li>
          <label for="rate">Rate</label>
          <select id="rate" name="rate">
            <option value="44" selected>44,100 Hz</option>
            <option value="22">22,050 Hz</option>
            <option value="11">11,025 Hz</option>
            <option value="8">8,000 Hz</option>
            <option value="5">5,512 Hz</option>
          </select>
        </li>

        <li>
          <label for="gain">Gain</label>
          <select id="gain" name="gain">
          </select>
        </li>

        <li>
          <label for="silenceLevel">Silence Level</label>
          <select id="silenceLevel" name="silenceLevel">
          </select>
        </li>

        <li>
          <label for="silenceTimeout">Silence Timeout</label>
          <input id="silenceTimeout" name="silenceTimeout" value="2000"/>
        </li>

        <li>
          <input id="useEchoSuppression" name="useEchoSuppression" type="checkbox"/>
          <label for="useEchoSuppression">Use Echo Suppression</label>
        </li>

        <li>
          <input id="loopBack" name="loopBack" type="checkbox"/>
          <label for="loopBack">Loop Back</label>
        </li>

        <li>
          <button onclick="configureMicrophone();">Configure</button>
        </li>
      </ul>
    </form>
    -->

    </div> <!-- /container -->
@stop