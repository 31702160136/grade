/*
 Navicat Premium Data Transfer

 Source Server         : mydb
 Source Server Type    : MySQL
 Source Server Version : 80015
 Source Host           : localhost:3306
 Source Schema         : grade

 Target Server Type    : MySQL
 Target Server Version : 80015
 File Encoding         : 65001

 Date: 04/06/2019 22:10:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, '我是管理员，我最大', 'admin', 'admin', '123', 1111111, 111111111);

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '队名',
  `teacher_by_score` int(3) NOT NULL DEFAULT -1 COMMENT '队伍成绩',
  `student_id` bigint(20) NOT NULL DEFAULT -1 COMMENT '队长',
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `task_id`(`task_id`) USING BTREE,
  CONSTRAINT `group_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 159 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES (158, '小组2', 10, 23, 68, 1559632495, 1559646619);
INSERT INTO `group` VALUES (159, '34535', 1, 34, 68, 1559646673, 1559647650);
INSERT INTO `group` VALUES (161, '42', -1, 53, 68, 1559650796, 1559650796);
INSERT INTO `group` VALUES (163, '123', -1, 53, 69, 1559656563, 1559656563);
INSERT INTO `group` VALUES (164, '2424', 0, 23, 69, 1559656883, 1559657327);

-- ----------------------------
-- Table structure for group_score
-- ----------------------------
DROP TABLE IF EXISTS `group_score`;
CREATE TABLE `group_score`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `score` int(3) NOT NULL DEFAULT -1,
  `estimate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `from_group_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE,
  INDEX `from_group_id`(`from_group_id`) USING BTREE,
  CONSTRAINT `group_score_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_score_ibfk_2` FOREIGN KEY (`from_group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group_score
-- ----------------------------
INSERT INTO `group_score` VALUES (53, 11, '', 159, 158, 1559646769, 1559646769);
INSERT INTO `group_score` VALUES (56, 12, '', 161, 159, 1559650800, 1559650800);

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `department` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  `class` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级',
  `role` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `password` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES (20, '学生1', '计算机工程系', '17移动互联1班', 'student', '31702160101', '123', 1556863021, 1558940102);
INSERT INTO `student` VALUES (21, '学生2', '计算机工程系', '17移动互联1班', 'student', '31702160102', '123', 1556863057, 1556863119);
INSERT INTO `student` VALUES (22, '学生3', '计算机工程系', '17移动互联1班', 'student', '31702160103', '123', 1556863110, 1556863110);
INSERT INTO `student` VALUES (23, '学生4', '计算机工程系', '17移动互联1班1', 'student', '31702160104', '123', 1556863181, 1559410691);
INSERT INTO `student` VALUES (33, '学生5', '计算机工程系', '移动互联1', 'student', '31702160105', '123', 1557290078, 1557290078);
INSERT INTO `student` VALUES (34, '学生666', '计算机工程系', '移动互联1', 'student', '31702160106', '123', 1557290078, 1559648216);
INSERT INTO `student` VALUES (36, '学生7', '计算机工程系', '移动互联1', 'student', '31702160108', '123', 1557290078, 1557290078);
INSERT INTO `student` VALUES (37, '学生8', '计算机工程系', '移动互联1', 'student', '31702160109', '123', 1557290078, 1557290078);
INSERT INTO `student` VALUES (38, '学生9', '计算机工程系', '移动互联1', 'student', '31702160110', '123', 1557290078, 1557290078);
INSERT INTO `student` VALUES (39, '学生10', '计算机工程系', '移动互联1', 'student', '31702160111', '123', 1557290078, 1557290078);
INSERT INTO `student` VALUES (40, '学生11', '计算机工程系', '移动互联1', 'student', '31702160112', '123', 1557290078, 1557290078);

-- ----------------------------
-- Table structure for student_group
-- ----------------------------
DROP TABLE IF EXISTS `student_group`;
CREATE TABLE `student_group`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `student_id`(`student_id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE,
  CONSTRAINT `student_group_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 530 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student_group
-- ----------------------------
INSERT INTO `student_group` VALUES (509, 23, 158, 1559632495, 1559632495);
INSERT INTO `student_group` VALUES (510, 20, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (512, 22, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (515, 36, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (516, 37, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (517, 38, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (518, 39, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (519, 40, 158, 1559632514, 1559632514);
INSERT INTO `student_group` VALUES (530, 34, 159, 1559646673, 1559646673);
INSERT INTO `student_group` VALUES (534, 21, 159, 1559647307, 1559647307);
INSERT INTO `student_group` VALUES (535, 33, 159, 1559647307, 1559647307);
INSERT INTO `student_group` VALUES (543, 23, 164, 1559656883, 1559656883);

-- ----------------------------
-- Table structure for student_score
-- ----------------------------
DROP TABLE IF EXISTS `student_score`;
CREATE TABLE `student_score`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `score` int(3) NOT NULL DEFAULT -1 COMMENT '成绩',
  `from_student_id` bigint(20) UNSIGNED NOT NULL,
  `student_group_id` bigint(20) UNSIGNED NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `student_group_id`(`student_group_id`) USING BTREE,
  INDEX `from_student_group_id`(`from_student_id`) USING BTREE,
  CONSTRAINT `student_score_ibfk_1` FOREIGN KEY (`student_group_id`) REFERENCES `student_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for task
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curriculum` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程',
  `semester` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学期',
  `class` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级',
  `teacher_id` bigint(20) UNSIGNED NOT NULL COMMENT '老师',
  `is_archive` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否存档',
  `weight_teacher` tinyint(3) UNSIGNED NOT NULL,
  `weight_group` tinyint(3) UNSIGNED NOT NULL,
  `weight_group_in` tinyint(3) UNSIGNED NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `teacher_id`(`teacher_id`) USING BTREE,
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task
-- ----------------------------
INSERT INTO `task` VALUES (68, 'JAVA实训', '2019', '17移动互联1', 4, 0, 40, 30, 30, 1559632309, 1559648086);
INSERT INTO `task` VALUES (69, '123是', '12', '12', 4, 0, 12, 12, 21, 1559652458, 1559652458);

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher`  (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `creation_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES (4, '老师', 'teacher', '123', '123', 1555862848, 1559653343);

SET FOREIGN_KEY_CHECKS = 1;
