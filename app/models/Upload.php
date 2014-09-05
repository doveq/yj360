<?php

/*
	上传集中处理
*/

class Upload  
{

	protected $table = 'uploads';
	
	// 上传类型
	public $typeEnum = array('recorder' => 1);

	// 文件类型
	public $fileTypeEnum = array('wav' => 1, 'mp3' => 2, 'flv' => 3, 'img' => 4);

	/* 上传信息添加数据库 */
	public function insert($type, $uid, $tid, $fileName, $fileType)
	{
		$_type = $this->typeEnum[$type];
		$_filetype = $this->fileTypeEnum[$fileType];

		// 如果是录音上传，只保存最新信息
		if($type == 'recorder')
		{
			$find = DB::table($this->table)->where('tid', $tid)->where('uid', $uid)->where('type', $this->typeEnum['recorder'])->get();
			if($find)
			{
				// 跟新时间
				DB::table($this->table)->where('id', $find[0]->id)->update(array('created_at' => date('Y-m-d H:i:s')));
				return $find[0]->id;
			}
		}

		$id = DB::table($this->table)->insertGetId(array(
				   'uid' =>  $uid, 
    			   'tid' => $tid,
    			   'type' => $_type,
    			   'created_at' => date('Y-m-d H:i:s'),
    			   'file_name' => $fileName,
    			   'file_type' => $_filetype,
    		));

    	return $id;
	}

	/* 上传录音文件，只保存每个用户每题的最新录音。

		$file 上传文件
		$uid  用户id
		$tid  题目id
		$type 文件类型

		return -1 文件保存路径错误
		       -2 录音文件格式错误
		        0 失败
		        1 成功
	*/
	public function setRecorder($file, $uid, $tid, $type = 'wav')
	{
		$route = $this->getRecorderRoute($uid, $tid, $type);

		if( !file_exists($route['folder']) ) 
		{
		  if( !mkdir($route['folder'], 0777, true) )
		  	  return -1;
		}

		
		$saved = 0;
		if($type == 'wav' && $this->validWavFile($file)) 
		{
			if( move_uploaded_file($file, $route['path']) )
			{
				$this->insert('recorder', $uid, $tid, $route['name'], $type);
				$saved = 1;
			}
		}

		return $saved;
	}

	/*  获取录音路径 
		return  
			folder: 保存目录绝对路径
			name: 生成文件名
			path: 文件绝对路径
			url: url访问路径
	*/
	public function getRecorderRoute($uid, $tid, $type = 'wav')
	{
		$folder = Config::get('app.recorder_dir') .'/'. $uid;
		$name = md5( $tid . $type . $uid) .'.'. $type;
		$path = $folder .'/'. $name;
		$url = Config::get('app.recorder_url') .'/'. $uid .'/'. $name;

		return array(
			'folder' => $folder,
			'name' => $name,
			'path' => $path,
			'url' => $url,
			);
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
