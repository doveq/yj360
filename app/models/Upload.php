<?php

/*
	上传集中处理
*/

class Upload  
{

	/* 上传录音文件 
		$file 上传文件
		$uid  用户id
		$tid  题目id
		$type 文件类型

		return -1 文件保存路径错误
		       -2 录音文件格式错误
		        0 失败
		        1 成功
	*/
	public function recorder($file, $uid, $tid, $type = 'wav')
	{
		$saveFolder = Config::get('app.recorder_dir') .'/'. $uid;

		if( !file_exists($saveFolder) ) 
		{
		  if( !mkdir($saveFolder, 0777, true) )
		  	  return -1;
		}

		$filename = "{$saveFolder}/{$tid}.{$type}";
		$saved = 0;
		if($type == 'wav' && $this->validWavFile($file)) {
		  	$saved = move_uploaded_file($file, $filename) ? 1 : 0;
		}

		return $saved;
	}

	/* 验证wav文件 */
	function validWavFile($file) 
	{
	  	$handle = fopen($file, 'r');
	  	$header = fread($handle, 4);
	  	list($chunk_size) = array_values(unpack('V', fread($handle, 4)));
	  	$format = fread($handle, 4);
	  	fclose($handle);
	  	return $header == 'RIFF' && $format == 'WAVE' && $chunk_size == (filesize($file) - 8);
	}

}
