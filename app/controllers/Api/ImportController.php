<?php namespace Api;
use Attachments;
use Topic;

/* 批量导入题目数据 */
class ImportController extends \BaseController {

    public function index()
    {
        $this->info();
    }


    /* 解析文本文件 */
    public function entxt($smfile)
    {
        $file_handle = fopen($smfile, "r");

        $info = array();
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $line = mb_convert_encoding($line, "UTF-8", "GB2312");

            $lines = explode(":", $line);
            switch ($lines[0]) {
                case 'FloderName':
                    $info['source'] = $lines[1];  // 原始编号
                    break;
                case 'title':
                    $info['txt'] = $lines[1];  // 标题
                    break;
                case 'A':
                    if ($lines[1] != '') {
                        $ap = $lines[1];
                    }
                    break;
                case 'B':
                    if ($lines[1] != '') {
                        $bp = $lines[1];
                    }
                    break;
                case 'C':
                    if ($lines[1] != '') {
                        $cp = $lines[1];
                    }
                    break;
                case 'D':
                    if ($lines[1] != '') {
                        $dp = $lines[1];
                    }
                    break;
                case 'E':
                    if ($lines[1] != '') {
                        $ep = $lines[1];
                    }
                    break;
                case 'F':
                    if ($lines[1] != '') {
                        $fp = $lines[1];
                    }
                    break;
                case 'type':
                    $type = $lines[1];
                    break;
                case 'answer':
                    $answer = $lines[1];
                    break;
                default:
                    # code...
                    break;
            }
            // echo $line;
        }
        fclose($file_handle);
    }

    public function info()
    {    
        $dir_root = public_path() .'/data/questions';
        require $dir_root . "/import_config.php";
        // var_dump($info);

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
                        $thisdir = $dir . "/" . $entry;
                        $smfile = $thisdir . "/sm.txt";
                        echo $smfile . "\n\r";
                        
                        $this->entxt($smfile);

                        //判断目录下有没有各种文件:
                        if (is_file($thisdir . "/ts.mp3")) {
                            $ts = 'ts.mp3';
                        }

                        //test
                        echo $cp . "\n\r";
                    }
                }

                $d->close();
            }
        }


    }// function end

}
