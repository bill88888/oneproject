/*
Navicat MySQL Data Transfer

Source Server         : 我的MySQL
Source Server Version : 50723
Source Host           : localhost:3306
Source Database       : mybbs

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2019-09-05 11:13:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bbs_cate
-- ----------------------------
DROP TABLE IF EXISTS `bbs_cate`;
CREATE TABLE `bbs_cate` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `cname` varchar(255) NOT NULL COMMENT '模块名称',
  `pid` int(11) NOT NULL COMMENT '模块分区',
  `created_at` int(20) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(20) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `cname` (`cname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_cate
-- ----------------------------
INSERT INTO `bbs_cate` VALUES ('1', '走马', '1', '1561081166', null);
INSERT INTO `bbs_cate` VALUES ('2', '虚拟', '1', '1561081173', null);
INSERT INTO `bbs_cate` VALUES ('3', '谋杀屋', '2', '1561082061', null);
INSERT INTO `bbs_cate` VALUES ('4', '奇妙能力歌', '1', '1561082101', null);
INSERT INTO `bbs_cate` VALUES ('5', '疯人院', '2', '1561082113', null);
INSERT INTO `bbs_cate` VALUES ('6', '女巫', '2', '1561082202', null);
INSERT INTO `bbs_cate` VALUES ('7', '畸形秀', '2', '1561082211', null);
INSERT INTO `bbs_cate` VALUES ('8', 'bbbb', '3', '1561086608', '1561086631');

-- ----------------------------
-- Table structure for bbs_part
-- ----------------------------
DROP TABLE IF EXISTS `bbs_part`;
CREATE TABLE `bbs_part` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `pname` varchar(20) NOT NULL COMMENT '分区名称',
  `uid` int(11) DEFAULT NULL COMMENT '分区版主',
  `created_at` int(20) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(20) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pname` (`pname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_part
-- ----------------------------
INSERT INTO `bbs_part` VALUES ('1', '民谣', '1', '1561081155', '1561081155');
INSERT INTO `bbs_part` VALUES ('2', '美国恐怖故事', '20', '1561082041', '1561082041');
INSERT INTO `bbs_part` VALUES ('3', 'hhhh', '22', '1561086598', '1561086598');

-- ----------------------------
-- Table structure for bbs_post
-- ----------------------------
DROP TABLE IF EXISTS `bbs_post`;
CREATE TABLE `bbs_post` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(255) NOT NULL COMMENT '帖子标题',
  `content` text NOT NULL COMMENT '内容',
  `uid` int(11) unsigned NOT NULL COMMENT '发帖者编号',
  `cid` int(11) unsigned NOT NULL COMMENT '所属模版编号',
  `is_jing` tinyint(4) unsigned DEFAULT '0' COMMENT '是否加精 0普通 1加精',
  `is_ding` tinyint(4) unsigned DEFAULT '0' COMMENT '是否置顶 0普通 1置顶',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '修改时间',
  `v_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数',
  `r_cnt` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  `hidden` tinyint(4) DEFAULT '0' COMMENT '隐藏',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_post
-- ----------------------------
INSERT INTO `bbs_post` VALUES ('1', '歌词第一句', '窗外雨都停了 屋里灯还黑着', '1', '1', '0', '0', '1561081421', '1561081421', '10', '1', '1');
INSERT INTO `bbs_post` VALUES ('2', '我曾和泰特相恋', 'Tate i love you, but i don\'t forgive you, you kill my mum!', '19', '3', '0', '0', '1561083027', '1561083027', '7', '1', '1');
INSERT INTO `bbs_post` VALUES ('3', '我也听过这首歌', '挺好听', '21', '4', '0', '0', '1561083639', '1561083639', '0', '0', '1');
INSERT INTO `bbs_post` VALUES ('4', '你是我未曾拥有无法捕捉的亲昵', '我却有你的吻你的魂你的心', '21', '2', '0', '0', '1561084385', '1561084385', '0', '0', '1');
INSERT INTO `bbs_post` VALUES ('5', '走马真好听呀!', '陈粒写歌的风格', '21', '1', '0', '0', '1561084657', '1561084657', '0', '0', '1');
INSERT INTO `bbs_post` VALUES ('6', '过了很久终于我愿抬头看', '你就在对岸走的好慢', '21', '1', '1', '1', '1561084727', '1561084727', '0', '0', '1');
INSERT INTO `bbs_post` VALUES ('9', 'aaaaa', 'qqqqqqqq', '23', '1', '1', '0', '1561086825', '1561086825', '6', '2', '1');

-- ----------------------------
-- Table structure for bbs_reply
-- ----------------------------
DROP TABLE IF EXISTS `bbs_reply`;
CREATE TABLE `bbs_reply` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '回复帖子编号',
  `message` varchar(255) NOT NULL COMMENT '回复内容',
  `uid` int(10) unsigned NOT NULL COMMENT '回复者编号',
  `pid` int(11) NOT NULL COMMENT '帖子编号',
  `created_at` int(10) unsigned DEFAULT NULL COMMENT '回复时间',
  `updated_at` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_reply
-- ----------------------------
INSERT INTO `bbs_reply` VALUES ('1', '第二句呢？', '19', '1', '1561081601', '1561081601');
INSERT INTO `bbs_reply` VALUES ('2', 'i love you ', '21', '2', '1561083485', '1561083485');
INSERT INTO `bbs_reply` VALUES ('3', 'ccccccccccccccccccc', '23', '8', '1561086880', '1561086880');
INSERT INTO `bbs_reply` VALUES ('4', '啊啊啊啊啊啊啊\r\n', '1', '9', '1561090042', '1561090042');

-- ----------------------------
-- Table structure for bbs_user
-- ----------------------------
DROP TABLE IF EXISTS `bbs_user`;
CREATE TABLE `bbs_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID号',
  `uname` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `upwd` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `sex` enum('w','m','x') DEFAULT 'w' COMMENT '性别',
  `age` tinyint(3) unsigned DEFAULT NULL COMMENT '年龄',
  `uface` varchar(200) DEFAULT NULL COMMENT '头像',
  `auth` tinyint(4) DEFAULT '3' COMMENT '1代表超级管理员 2代表普通管理员 3代表普通用户',
  `tel` char(11) DEFAULT NULL COMMENT '电话',
  `create_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_at` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uname` (`uname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_user
-- ----------------------------
INSERT INTO `bbs_user` VALUES ('1', '陈粒', '$2y$10$W7OJTpHfMUrpLz1siaWr8.RBPqtHTRvbvPz5qizdjGzvryH02fYWy', 'w', '0', '20190617/5d07aa404383e.jpg', '1', '11011', '1560676490', '1561079632');
INSERT INTO `bbs_user` VALUES ('19', '法米加', '$2y$10$.DpTfPmP5BugQHlyk.G9JeXmNiXUQFmA4OkOXVvUQgHFAjm3JW18q', 'w', '0', '20190621/5d0c36e44fd4b.jpg', '3', '199', '1561081572', '1566312813');
INSERT INTO `bbs_user` VALUES ('20', 'bill', '$2y$10$4olxlgq7oaD7tVRH82jbLOUZZdauc2AdaXBKduIICQMGIM6XdWUX6', 'm', '19', '20190621/5d0c388f9e4ec.jpg', '1', '', '1561081999', '1561081999');
INSERT INTO `bbs_user` VALUES ('21', 'Tate', '$2y$10$dcW.m8pD0h3gz3yVQuODI.cjE8XyhgC.WssyVp1aL2p7VYgsQpkhq', 'w', null, '20190621/5d0c3dc4a3bd1.jpg', '3', '122', '1561083332', null);
INSERT INTO `bbs_user` VALUES ('18', '孙艺珍', '$2y$10$RLPZ3RluMBq4XuBq4sVSIOYPO///dySq25/rLzoDcccBBPuAf3VuS', 'w', '37', '20190621/5d0c30b679768.jpg', '2', '130110', '1561079990', '1561079990');
INSERT INTO `bbs_user` VALUES ('22', 'hhhh', '$2y$10$0OI8XuhKaXOq6LA8.h7FXOf2OLKophvWs5fXuVLm2JaLonMRuAtVi', 'm', '1', '20190621/5d0c4a54d4ccd.png', '1', '1', '1561086548', '1561086583');
INSERT INTO `bbs_user` VALUES ('23', 'qqqq', '$2y$10$GYPwhRAPm43s9MsRm/7rVe3MGb5LVphibZGXwd4ttsFNuoPzeh.Bi', 'w', null, '20190621/5d0c4aebc9f7f.jpg', '3', '123', '1561086666', null);
