CREATE TABLE IF NOT EXISTS `yzn_test` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0:男,1:女',
  `image` mediumint(8) unsigned NOT NULL COMMENT '头像图片',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未通过,1正常,2未审核',
  `inputtime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='名单表';