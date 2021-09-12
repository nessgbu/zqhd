-- 用户表
DROP TABLE IF EXISTS `yzn_users`;
CREATE TABLE `yzn_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `openid` varchar(100) NOT NULL COMMENT '微信openid',
  `nickname` varchar(100) NOT NULL COMMENT '昵称',
  `headimg` text COMMENT '头像',
  `last_time` int(11) DEFAULT NULL COMMENT '上次登录时间',
  `sex` int(1) DEFAULT NULL COMMENT '性别',
  `age` int(10) DEFAULT NULL COMMENT '年龄',
  `country` varchar(30) DEFAULT NULL COMMENT '国家',
  `province` varchar(30) DEFAULT NULL COMMENT '省',
  `city` varchar(30) DEFAULT NULL COMMENT '城市',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';

-- 亨通灯7%        安康灯20%        如意灯3%        顺心灯30%        兴旺灯40%
-- 亨通灯
DROP TABLE IF EXISTS `yzn_hengtong`;
CREATE TABLE `yzn_hengtong` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` int(11) DEFAULT NULL COMMENT '获取时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='亨通灯';

-- 安康灯
DROP TABLE IF EXISTS `yzn_ankang`;
CREATE TABLE `yzn_ankang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` int(11) DEFAULT NULL COMMENT '获取时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='安康灯';

-- 如意灯
DROP TABLE IF EXISTS `yzn_wishful`;
CREATE TABLE `yzn_wishful` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` int(11) DEFAULT NULL COMMENT '获取时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='如意灯';

-- 顺心灯
DROP TABLE IF EXISTS `yzn_agreeable`;
CREATE TABLE `yzn_agreeable` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` int(11) DEFAULT NULL COMMENT '获取时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='顺心灯';

-- 兴旺灯
DROP TABLE IF EXISTS `yzn_flourishing`;
CREATE TABLE `yzn_flourishing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` int(11) DEFAULT NULL COMMENT '获取时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='兴旺灯';

-- 兑换表
DROP TABLE IF EXISTS `yzn_exchange`;
CREATE TABLE `yzn_exchange` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `time` int(11) DEFAULT NULL COMMENT '兑换时间',
  `code` varchar(20) DEFAULT NULL COMMENT '兑换码',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='兑换表';

ALTER TABLE `yzn_hengtong` ADD `sharedid` int(11) DEFAULT NULL COMMENT '灯来源id';
ALTER TABLE `yzn_ankang` ADD `sharedid` int(11) DEFAULT NULL COMMENT '灯来源id';
ALTER TABLE `yzn_wishful` ADD `sharedid` int(11) DEFAULT NULL COMMENT '灯来源id';
ALTER TABLE `yzn_agreeable` ADD `sharedid` int(11) DEFAULT NULL COMMENT '灯来源id';
ALTER TABLE `yzn_flourishing` ADD `sharedid` int(11) DEFAULT NULL COMMENT '灯来源id';

ALTER TABLE `yzn_hengtong` ADD `status` int(1) DEFAULT 1 COMMENT '状态';
ALTER TABLE `yzn_ankang` ADD `status` int(1) DEFAULT 1 COMMENT '状态';
ALTER TABLE `yzn_wishful` ADD `status` int(1) DEFAULT 1 COMMENT '状态';
ALTER TABLE `yzn_agreeable` ADD `status` int(1) DEFAULT 1 COMMENT '状态';
ALTER TABLE `yzn_flourishing` ADD `status` int(1) DEFAULT 1 COMMENT '状态';

ALTER TABLE `yzn_users` ADD `pid` int(10) DEFAULT 0 COMMENT '邀请用户id';

