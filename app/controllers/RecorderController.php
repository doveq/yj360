<?php

// flash录音处理

class RecorderController extends BaseController 
{

	public function __construct()
    {
    	
    }

	/* 显示测试页面 */
	public function index()
	{
		return $this->indexView('recorder');
	}


	/* 上传录音数据 */
	public function upload()
	{
		$upload = new Upload();
		#Log::info( var_export($_FILES, true) );
		$saved = $upload->recorder($_FILES["upload_file"]["tmp_name"]['filename'], 'testname');

		if($_POST['format'] == 'json') {
		  header('Content-type: application/json');
		  print "{\"saved\": $saved}";
		} else {
		  print $saved ? "Saved" : 'Not saved';
		}
	}
}
