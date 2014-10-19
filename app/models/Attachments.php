<?php

/*
	附件集中处理
*/

class Attachments  
{

	protected $table = 'attachments';
	
	// 附件类型
	public $typeEnum = array('recorder' => 1, 'topic' => 2);

	// 文件类型
	public $fileTypeEnum = array('wav' => 1, 'mp3' => 2, 'flv' => 3, 'jpg' => 4, 'swf' => 5);


	/* 根据id获取附件信息 */
	public function get($attid)
	{
		$find = DB::table($this->table)->where('id', $attid)->get();
		if($find)
			return (array)$find[0];
		else
			return false;
	}

	/* 删除附件信息 */
	public function del($attid)
	{
		$info = $this->get($attid);
		if($info)
		{
			// 删除数据和文件
			if($info['type'] == 2)
			{
				DB::table($this->table)->where('id', $info['id'])->delete();
				$route = $this->getTopicRoute($info['qid'], $info['file_name']);
				unlink($route['path']);
			}
		}
	}

	/* 信息添加数据库 */
	public function insert($type, $uid, $qid, $fileName, $fileType)
	{
		$_type = $this->typeEnum[$type];
		$_filetype = $this->fileTypeEnum[$fileType];

		// 如果是录音上传，只保存最新信息
		if($type == 'recorder')
		{
			$find = DB::table($this->table)->where('qid', $qid)->where('uid', $uid)->where('type', $this->typeEnum['recorder'])->get();
			if($find)
			{
				// 跟新时间
				DB::table($this->table)->where('id', $find[0]->id)->update(array('created_at' => date('Y-m-d H:i:s')));
				return $find[0]->id;
			}
			else
			{
				$id = DB::table($this->table)->insertGetid(array(
					   'uid' =>  $uid, 
	    			   'qid' => $qid,
	    			   'type' => $_type,
	    			   'created_at' => date('Y-m-d H:i:s'),
	    			   'file_name' => $fileName,
	    			   'file_type' => $_filetype,
	    		));

	    		return $id;
			}
		}
		else
		{
			$id = DB::table($this->table)->insertGetid(array(
					   'uid' =>  $uid, 
	    			   'qid' => $qid,
	    			   'type' => $_type,
	    			   'created_at' => date('Y-m-d H:i:s'),
	    			   'file_name' => $fileName,
	    			   'file_type' => $_filetype,
	    		));

	    	return $id;
    	}
	}

	/* 保存录音文件，只保存每个用户每题的最新录音。

		$file 上传文件
		$uid  用户id
		$qid  题目id
		$type 文件类型

		return -1 文件保存路径错误
		       -2 录音文件格式错误
		        0 失败
		        1 成功
	*/
	public function addRecorder($file, $uid, $qid, $type = 'wav')
	{
		$route = $this->getRecorderRoute($uid, $qid, $type);

		if( !file_exists($route['folder']) ) 
		{
		  if( !mkdir($route['folder'], 0777, true) )
		  	  return -1;
		}

		$attid = 0;
		if( rename($file, $route['path']) )
		{
			//$attid = $this->insert('recorder', $uid, $qid, $route['name'], $type);
			return 1;
		}

		return $attid;
	}

	/*  获取录音路径 
		return  
			folder: 保存目录绝对路径
			name: 生成的文件名
			path: 文件绝对路径
			url: url访问路径
	*/
	public function getRecorderRoute($uid, $qid, $type = 'wav')
	{
		$folder = Config::get('app.recorder_dir') .'/'. $uid;
		$name = md5( $qid . $type . $uid) .'.'. $type;
		$path = $folder .'/'. $name;
		$url = Config::get('app.recorder_url') .'/'. $uid .'/'. $name;

		return array(
			'folder' => $folder,
			'name' => $name,
			'path' => $path,
			'url' => $url,
			);
	}

	/* 验证图片文件 */
	public function validImgFile($file)
	{
		$type = exif_imagetype($file);
		if($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG ||
			$type == IMAGETYPE_BMP)
		{
			return 1;
		}

		return 0;
	}


	/* 添加问题附件 */
	public function addTopicImg($qid, $file)
	{
		if( !$this->validImgFile($file) )
			return 0;

		// 生成文件名
		$name = md5( $qid . uniqid() ) . '.jpg';
		
		$route = $this->getTopicRoute($qid, $name);

		if(!is_dir($route['folder']))
            mkdir($route['folder'], 0777, true);

        $attid = 0;
        if( rename($file, $route['path']) )
		{
			$attid = $this->insert('topic', 0, $qid, $name, 'jpg');
		}

		return $attid;
	}

	public function addTopicAudio($qid, $file, $type)
	{
		// 生成文件名
		$name = md5( $qid . uniqid() ) . '.' . $type;
		
		$route = $this->getTopicRoute($qid, $name);

		if(!is_dir($route['folder']))
            mkdir($route['folder'], 0777, true);

        $attid = 0;
        if( rename($file, $route['path']) )
		{
			$attid = $this->insert('topic', 0, $qid, $name, $type);
		}

		return $attid;
	}

	/*  获取问题附件路径 
		return  
			folder: 保存目录绝对路径
			path: 文件绝对路径
			url: url访问路径
	*/
	public function getTopicRoute($qid, $name)
	{
		$dir = $qid - ($qid % 1000);
		$folder = Config::get('app.topic_dir') .'/'. $dir;

		$path = $folder .'/'. $name;
		$url = Config::get('app.topic_url') .'/'. $dir .'/'. $name;

		return array(
			'folder' => $folder,
			'path' => $path,
			'url' => $url,
			);
	}


	/* 获取文件扩展名 */
	public function getExt($name)
	{
		return strtolower( pathinfo($name, PATHINFO_EXTENSION) );
	}
}
