<?php

class Sql
{
	function Up()
	{

		DB::statement('drop table if exists `users`');
		$table = "
			CREATE TABLE IF NOT EXISTS `users` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
			  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `tel` char(13) NOT NULL COMMENT '手机号码',
			  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
			  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '用户类型，0:学生, 1:老师, -1:管理员',
			  `is_avatar` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有自定义头像，0:没有,1:有',
			  `is_certificate` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有教师证，0:没有,1:有',
			  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
			  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
			  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '账号状态 0:未审核, 1:审核通过，-1:审核拒绝',
			  `remember_token` varchar(100) NOT NULL DEFAULT '',
			  PRIMARY KEY (`id`),
			  KEY `tel` (`tel`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($table);

		$sql = "
			INSERT INTO `users` (`id`, `name`, `email`, `tel`, `password`, `type`, `is_avatar`, `is_certificate`, `created_at`, `updated_at`, `status`) VALUES
			(1, 'admin', '', '0000000000000', '5f1d7a84db00d2fce00b31a7fc73224f', -1, 0, 0, '2014-08-28 19:01:10', '2014-08-28 19:01:10', 1)
		";
		DB::statement($sql);


		DB::statement('drop table if exists `attachments`');
		$table = "
			CREATE TABLE IF NOT EXISTS `attachments` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户id',
			  `qid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属题目id',
			  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '类型，1:用户录音上传，2:题干附件',
			  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
			  `file_name` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名',
			  `file_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '文件类型，1:mav, 2:mp3, 3:flv, 4:jpg',
			  PRIMARY KEY (`id`),
			  KEY `uid` (`uid`),
			  KEY `qid` (`qid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($table);

		DB::statement('drop table if exists `questions`');
		$table = "
			CREATE TABLE IF NOT EXISTS `questions` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `txt` varchar(255) NOT NULL DEFAULT '' COMMENT '题干文字',
			  `hint` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '提示音',
			  `sound` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '题干音',
			  `img` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '题干图片',
			  `flash` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '题干flash',
			  `disabuse` text NOT NULL DEFAULT '' COMMENT '题目详解',
			  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
			  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '题目类型',
			  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0:未审核, 1:审核通过，-1:审核拒绝',
			  `source` varchar(100) NOT NULL DEFAULT '' COMMENT '原始题目编号',
			  `author` varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
			  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '介绍',
			  PRIMARY KEY (`id`),
			  KEY `type` (`type`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($table);

		DB::statement('drop table if exists `answers`');
		$table = "
			CREATE TABLE IF NOT EXISTS `answers` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `qid` int(11) unsigned NOT NULL COMMENT '题目id',
			  `txt` varchar(255) NOT NULL DEFAULT '' COMMENT '答案文字',
			  `sound` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '答案配音',
			  `img` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '答案图片',
			  `flash` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '答案视频',
			  `is_right` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0:错误答案, 1:正确答案',
			  PRIMARY KEY (`id`),
			  KEY `qid` (`qid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($table);


		DB::statement('drop table if exists `result_log`');
		$table = "
			CREATE TABLE IF NOT EXISTS `result_log` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
			  `qid` int(11) unsigned NOT NULL COMMENT '题目id',
			  `column_id` int(11) unsigned NOT NULL COMMENT '科目id',
			  `is_true` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0:回答错误, 1:回答正确',
			  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
			  `uniqid` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一id,区分每次用户做题',
			  PRIMARY KEY (`id`),
			  KEY `qid` (`uid`),
			  KEY `column_id` (`column_id`),
			  KEY `uniqid` (`uniqid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($table);

		DB::statement('drop table if exists `favorite`');
		$table = "
			CREATE TABLE IF NOT EXISTS `favorite` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
			  `qid` int(11) unsigned NOT NULL COMMENT '题目id',
			  PRIMARY KEY (`id`),
			  KEY `qid` (`uid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($table);
	}
	

	function Down()
	{
		DB::statement('drop table if exists `users`');
	}

}
