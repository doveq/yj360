<?php
$dir_root = realpath(__DIR__ . "/../../public/data/questions");
require $dir_root . "/import_config.php";
// var_dump($info);

foreach ($info as $key => $config) {
    $dir = $dir_root . "/" .$config['dir'];
    if (is_dir($dir)) {
        $d = dir($dir);
        while (false !== ($entry = $d->read())) {
            if ($entry != '.' && $entry != '..' && substr($entry, 0, 1) != '.') {
                // echo $entry."\n";
                $thisdir = $dir . "/" . $entry;
                $smfile = $thisdir . "/sm.txt";
                echo $smfile . "\n\r";
                $file_handle = fopen($smfile, "r");
                while (!feof($file_handle)) {
                    $line = fgets($file_handle);
                    $lines = explode(":", $line);
                    switch ($lines[0]) {
                        case 'FloderName':
                            $ysbh = $lines[1];
                            break;
                        case 'title':
                            $tg = $lines[1];
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
