<?php

class Sql
{
	function Up()
	{

		DB::statement('drop table if exists `users`');
		$userTable = "
			CREATE TABLE IF NOT EXISTS `users` (
			  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
			  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
			  `tel` char(13) NOT NULL COMMENT '手机号码',
			  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
			  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '用户类型，0:学生, 1:老师, -1:管理员',
			  `is_avatar` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有自定义头像，0:没有,1:有',
			  `is_certificate` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有教师证，0:没有,1:有',
			  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
			  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
			  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '账号状态 0:无效, 1:生效',
			  PRIMARY KEY (`id`),
			  KEY `tel` (`tel`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		DB::statement($userTable);

	}


	function Down()
	{
		DB::statement('drop table if exists `users`');
	}

}
