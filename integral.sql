# Host: localhost  (Version 5.5.53)
# Date: 2019-08-12 11:15:09
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "in_log"
#

DROP TABLE IF EXISTS `in_log`;
CREATE TABLE `in_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL COMMENT '用户id',
  `integral` int(11) DEFAULT NULL COMMENT '当月积分',
  `money` varchar(255) DEFAULT NULL COMMENT '获得金额',
  `down_money` varchar(255) DEFAULT NULL COMMENT '下级总金额',
  `time` bigint(16) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='奖金历史';

#
# Data for table "in_log"
#

/*!40000 ALTER TABLE `in_log` DISABLE KEYS */;
INSERT INTO `in_log` VALUES (1,'7',257,'0','0',1565061166),(2,'6',0,'0','0',1565061166),(3,'5',0,'0','0',1565061166),(4,'1',0,'0','0',1565061166),(5,'3',0,'0','0',1565061166),(6,'4',0,'0','0',1565061166),(7,'2',0,'0','0',1565061166),(8,'11',18000,'0','0',1565168426),(9,'10',18000,'0','0',1565168426),(10,'1',0,'0','0',1565168426),(11,'9',18000,'0','0',1565168426),(12,'8',18000,'0','0',1565168426),(13,'7',100,'0','0',1565168426),(14,'6',105,'0','0',1565168426),(15,'5',0,'0','0',1565168426),(16,'3',0,'0','0',1565168426),(17,'4',0,'0','0',1565168426),(18,'2',0,'0','0',1565168426);
/*!40000 ALTER TABLE `in_log` ENABLE KEYS */;

#
# Structure for table "inviation"
#

DROP TABLE IF EXISTS `inviation`;
CREATE TABLE `inviation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` int(11) DEFAULT NULL COMMENT '邀请人',
  `user` int(11) DEFAULT NULL COMMENT '被邀请人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='邀请表';

#
# Data for table "inviation"
#

/*!40000 ALTER TABLE `inviation` DISABLE KEYS */;
INSERT INTO `inviation` VALUES (1,1,2),(2,1,3),(3,3,4),(4,3,5),(5,6,7),(6,1,8),(7,1,9),(8,1,10);
/*!40000 ALTER TABLE `inviation` ENABLE KEYS */;

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(40) DEFAULT NULL COMMENT '登陆名',
  `name` varchar(40) DEFAULT NULL COMMENT '真实姓名',
  `time` bigint(16) DEFAULT NULL COMMENT '注册时间',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `integral` bigint(11) DEFAULT NULL COMMENT '积分',
  `money` varchar(255) DEFAULT NULL COMMENT '现金',
  `inv` varchar(255) DEFAULT NULL COMMENT '邀请人',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'user1','老王1号',1564729277,'17723580999','4297f44b13955235245b2497399d7a93',0,'0','0',NULL,1),(2,'user11','老王2号',1564729497,'17785484257','4297f44b13955235245b2497399d7a93',0,'0','0,1','01231',1),(3,'user12','老王3号',1564729521,'17785484254','4297f44b13955235245b2497399d7a93',0,'0','0,1',NULL,1),(4,'user121','老王4号',1564731012,'17723584451','4297f44b13955235245b2497399d7a93',0,'0','0,1,3',NULL,1),(5,'user1212','老王5号',1564731070,'18502398125','4297f44b13955235245b2497399d7a93',0,'0','0,1,3',NULL,1),(6,'admin1','老王6号',1564737941,'17723580910','4297f44b13955235245b2497399d7a93',0,'0','0','1010m',1),(7,'admin2','老王7号',1564737989,'18502398902','4297f44b13955235245b2497399d7a93',0,'0','0,6','100',1),(8,'user111','老王',1565064185,'17723580910','4297f44b13955235245b2497399d7a93',0,'0','0,1',NULL,3),(9,'asdasdasd','qweqweqw',1565064350,'17723580911','4297f44b13955235245b2497399d7a93',0,'0','0,1','adadsad',3),(10,'uiuiuiu','uiuiui',1565145669,'18502398988','4297f44b13955235245b2497399d7a93',0,'0','0,1','adasdadad',3),(11,'user5','张三',1565168262,'18502398902','4297f44b13955235245b2497399d7a93',0,'0','0','11111',1);
