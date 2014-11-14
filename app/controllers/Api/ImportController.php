<?php namespace Api;
set_time_limit(0);
header('Content-Type:text/html; charset=utf-8');

use DB;
use Attachments;
use Topic;
use SortQuestionRelation;

/* 批量导入题目数据 */
class ImportController extends \BaseController {

    public function __construct()
    {
        $this->att = new Attachments();
        $this->topic = new Topic();
        $this->sar = new SortQuestionRelation();
    }

    public function index()
    {
        $this->start();
    }

    /* 解析题目信息 */
    public function encode($path)
    {
        $smfile = $path . "/sm.txt";

        $info = array();
        $info['question'] = array();
        $info['answer'] = array();
        $info['answer'][0] = array();
        $info['answer'][1] = array();
        $info['answer'][2] = array();
        $info['answer'][3] = array();
        $info['answer'][4] = array();
        $info['answer'][5] = array();

        // 解析文本信息
        $file_handle = fopen($smfile, "r");
        while (!feof($file_handle)) 
        {
            $line = trim( fgets($file_handle) );
            $line = mb_convert_encoding($line, "UTF-8", "GBK");

            $lines = explode(":", $line, 2);
            switch ($lines[0]) {
                case 'FloderName':
                    $info['question']['source'] = $lines[1];  // 原始编号
                    break;
                case 'title':
                    $info['question']['txt'] = $lines[1];  // 标题
                    break;
                case 'type':
                    // 多选题：MCQ 单选题：SCQ 连线题：LQ 判断题：JQ 填空题：FBQ 写作题：EQ 模唱题：IQS 视唱题：SQS
                    // $typeEnum = array('1' => '单选择题', '2' => '多选择题',  '3' => '判断题', '4' => '填空题', '5' => '写作题', '6' => '模唱', '7' => '视唱', '8' => '视频', '9' => '教材', '10' => '游戏');
                    if( $lines[1] == 'SCQ')
                    {
                        $info['question']['type'] = 1;
                    }
                    else
                        return false;  // 不知道的题型则跳出
                    break;
                case 'A':
                    if ($lines[1] != '') {
                        $info['answer'][0]['txt'] = $lines[1];
                    }
                    break;
                case 'B':
                    if ($lines[1] != '') {
                        $info['answer'][1]['txt'] = $lines[1];
                    }
                    break;
                case 'C':
                    if ($lines[1] != '') {
                        $info['answer'][2]['txt'] = $lines[1];
                    }
                    break;
                case 'D':
                    if ($lines[1] != '') {
                        $info['answer'][3]['txt'] = $lines[1];
                    }
                    break;
                case 'E':
                    if ($lines[1] != '') {
                        $info['answer'][4]['txt'] = $lines[1];
                    }
                    break;
                case 'F':
                    if ($lines[1] != '') {
                        $info['answer'][5]['txt'] = $lines[1];
                    }
                    break;
                case 'An':
                    if ($lines[1] != '') {
                        $info['answer'][0]['explain'] = $lines[1];
                    }
                    break;
                case 'Bn':
                    if ($lines[1] != '') {
                        $info['answer'][1]['explain'] = $lines[1];
                    }
                    break;
                case 'Cn':
                    if ($lines[1] != '') {
                        $info['answer'][2]['explain'] = $lines[1];
                    }
                    break;
                case 'Dn':
                    if ($lines[1] != '') {
                        $info['answer'][3]['explain'] = $lines[1];
                    }
                    break;
                case 'En':
                    if ($lines[1] != '') {
                        $info['answer'][4]['explain'] = $lines[1];
                    }
                    break;
                case 'Fn':
                    if ($lines[1] != '') {
                        $info['answer'][5]['explain'] = $lines[1];
                    }
                    break;
                case 'answer':
                    $answer = $lines[1];
                    if ($lines[1] != '') 
                    {
                        if($lines[1] == 'A') $info['answer'][0]['is_right'] = 1;
                        elseif($lines[1] == 'B') $info['answer'][1]['is_right'] = 1;
                        elseif($lines[1] == 'C') $info['answer'][2]['is_right'] = 1;
                        elseif($lines[1] == 'D') $info['answer'][3]['is_right'] = 1;
                        elseif($lines[1] == 'E') $info['answer'][4]['is_right'] = 1;
                        elseif($lines[1] == 'F') $info['answer'][5]['is_right'] = 1;
                    }
                    break;
                default:
                    # code...
                    break;
            }
            // echo $line;
        }
        fclose($file_handle);

        // 题干图片
        if(is_file($path . '/tp.png')) 
            $info['question']['img_file'] = $path . '/tp.png';
        
        // 提干提示音
        if(is_file($path . '/ts.mp3')) 
            $info['question']['sound_file'] = $path . '/ts.mp3';

        // 提干音
        if(is_file($path . '/tm.mp3')) 
            $info['question']['hint_file'] = $path . '/tm.mp3';

        /* 答案图片 */
        if(is_file($path . '/AP.png')) 
            $info['answer'][0]['img_file'] = $path . '/AP.png';

        if(is_file($path . '/BP.png')) 
            $info['answer'][1]['img_file'] = $path . '/BP.png';

        if(is_file($path . '/CP.png')) 
            $info['answer'][2]['img_file'] = $path . '/CP.png';

        if(is_file($path . '/DP.png')) 
            $info['answer'][3]['img_file'] = $path . '/DP.png';

        if(is_file($path . '/EP.png')) 
            $info['answer'][4]['img_file'] = $path . '/EP.png';

        if(is_file($path . '/FP.png')) 
            $info['answer'][5]['img_file'] = $path . '/FP.png';

        /* 答案声音 */
        if(is_file($path . '/AM.wav')) 
            $info['answer'][0]['sound_file'] = $path . '/AM.wav';
        
        if(is_file($path . '/BM.wav')) 
            $info['answer'][1]['sound_file'] = $path . '/BM.wav';

        if(is_file($path . '/CM.wav')) 
            $info['answer'][2]['sound_file'] = $path . '/CM.wav';

        if(is_file($path . '/DM.wav')) 
            $info['answer'][3]['sound_file'] = $path . '/DM.wav';

        if(is_file($path . '/EM.wav')) 
            $info['answer'][4]['sound_file'] = $path . '/EM.wav';

        if(is_file($path . '/FM.wav')) 
            $info['answer'][5]['sound_file'] = $path . '/FM.wav';

        return $info;
    }

    /* 添加题目信息 */
    public function addQuestion($info)
    {

        $qid = $this->topic->add($info);

        // 添加分类信息
        $this->sar->addMap(array('sort' => $info['sort'], 'qid' => $qid));

        $questionAtt = array();
        if( !empty($info['img_file']) )
            $questionAtt['img'] = $this->att->addTopicImg($qid, $info['img_file']);

        if( !empty($info['sound_file']) )
        {
            $type = $this->att->getExt($info['sound_file']);
            $questionAtt['sound'] = $this->att->addTopicAudio( $qid, $info['sound_file'], $type);
        }

        if( !empty($info['hint_file']) )
        {
            $type = $this->att->getExt($info['hint_file']);
            $questionAtt['hint'] = $this->att->addTopicAudio( $qid, $info['hint_file'], $type);
        }

        if($questionAtt)
            $this->topic->edit($qid, $questionAtt);

        return $qid;
    }


    /* 添加答案信息 */
    public function addAnswer($qid, $info)
    {
        foreach($info as $answer) 
        {
            if( !empty($answer['img_file']) )
            {
                $answer['img'] = $this->att->addTopicImg($qid, $answer['img_file']);
            }

            if( !empty($answer['sound_file']) )
            {
                $type = $this->att->getExt($answer['sound_file']);
                $answer['sound'] = $this->att->addTopicAudio( $qid, $answer['sound_file'], $type);
            }

            $this->topic->addAnswers($qid, $answer);
        }
    }

    public function start()
    {
        $dir_root = public_path() .'/data/questions';
        require $dir_root . "/import_config.php";  // 获取 $info 数据
        
        foreach ($info as $key => $config) 
        {
            $dir = $dir_root . "/" .$config['dir'];
            if (is_dir($dir)) 
            {
                $d = dir($dir);
                while (false !== ($entry = $d->read())) {
                    if ($entry != '.' && $entry != '..' && substr($entry, 0, 1) != '.') 
                    {
                        // echo $entry."\n";
                        $qid = 0;

                        $thisdir = $dir . "/" . $entry;
                        
                        $tpinfo = $this->encode($thisdir);

                        if($tpinfo)
                        {
                            // 根据原始编号判断是否已经入库
                            $qinfo = DB::table('questions')->where('source', $tpinfo['question']['source'])->first();
                            if(!$qinfo)
                            {
                                $tpinfo['question']['sort'] = $config['sort'];  // 题库分类
                                
                                $qid = $this->addQuestion($tpinfo['question']);
                                if($qid)
                                {
                                    $this->addAnswer($qid, $tpinfo['answer']);
                                }

                                $this->delTree($thisdir);
                                print_r($tpinfo['question']['source']);
                            }
                        }

                    }
                }

                $d->close();
            }
        }

        echo "完成！！！";
    }// function end

    // 删除目录和目录下的文件
    public function delTree($dir) 
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) 
        {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    } 

}
