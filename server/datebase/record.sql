-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-03-30 05:59:47
-- 服务器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `Record`
--

-- --------------------------------------------------------

--
-- 表的结构 `chen_yaopu_review`
--

CREATE TABLE `chen_yaopu_review` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '序号',
  `date` int(11) NOT NULL COMMENT '日期',
  `purpose` text NOT NULL COMMENT '目的',
  `initiator` varchar(50) NOT NULL COMMENT '会议发起人',
  `participants` text NOT NULL COMMENT '参会人',
  `conclusion` text NOT NULL COMMENT '结论',
  `screenshot_url` varchar(500) DEFAULT NULL COMMENT '截图地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='陈堯朴复盘记录';

-- --------------------------------------------------------

--
-- 表的结构 `review_record`
--

CREATE TABLE `review_record` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '序号',
  `country` varchar(50) NOT NULL COMMENT '国家',
  `record_id` int(10) UNSIGNED NOT NULL COMMENT '关联升级记录表ID',
  `review_content` text NOT NULL COMMENT '复盘内容',
  `review_time` datetime NOT NULL COMMENT '复盘时间',
  `reviewer` varchar(50) NOT NULL COMMENT '复盘人',
  `conclusion` text NOT NULL COMMENT '复盘结论',
  `screenshot_url` varchar(500) DEFAULT NULL COMMENT '截图地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='复盘记录表';

-- --------------------------------------------------------

--
-- 表的结构 `upgrade_record`
--

CREATE TABLE `upgrade_record` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '序号',
  `country` varchar(50) NOT NULL COMMENT '国家',
  `content` text NOT NULL COMMENT '升级内容',
  `update_time` datetime NOT NULL COMMENT '更新时间(北京时间)',
  `updater` varchar(50) NOT NULL COMMENT '更新人',
  `tester` varchar(50) NOT NULL COMMENT '测试人员',
  `type` enum('新功能','新游戏','bug修复','功能优化') NOT NULL COMMENT '类型',
  `platform` enum('前端','后端','前后端','数据库') NOT NULL COMMENT '前后端',
  `is_review` int(1) NOT NULL DEFAULT 0,
  `review_conclusion` text DEFAULT NULL COMMENT '复盘结论',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='升级记录表';

--
-- 转存表中的数据 `upgrade_record`
--

INSERT INTO `upgrade_record` (`id`, `country`, `content`, `update_time`, `updater`, `tester`, `type`, `platform`, `is_review`, `review_conclusion`, `remark`) VALUES
(2, 'BR', '1.修复部分机型不兼容支付弹窗问题\n【影响范围】：美国线上全部分包', '2025-03-29 14:54:14', '3、4', '12、14、13', '新游戏', '前端', 0, NULL, 'https://alidocs.dingtalk.com/i/nodes/qnYMoO1rWxD1mxL4sM4ND1XBW47Z3je9?doc_type=wiki_doc'),
(3, 'US', '1.修复部分机型不兼容支付弹窗问题 \n【影响范围】：美国线上全部分包\n', '2025-03-29 14:56:00', '王子腾、陶俊华、曹方毅', '王雪斌、钱星瑞', '新功能', '后端', 0, NULL, 'https://alidocs.dingtalk.com/i/nodes/qnYMoO1rWxD1mxL4sM4ND1XBW47Z3je9?doc_type=wiki_doc'),
(4, 'US', '美国H5上线 (2025/03/27 20:20:00) 更新内容：\n1. 互导APK新增FB绑定\nꔷ 【影响范围】：h5us4dk01_001, h5us4fd01_001, h5us4mb01_001, h5us4ps01_001', '2025-03-30 01:03:09', '梁嘉轩', '王然', '新功能', '前端', 0, NULL, '无');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '序号',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `position` varchar(100) NOT NULL COMMENT '岗位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户信息表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `position`) VALUES
(3, '梁嘉轩', '前端'),
(4, '王子腾', '前端'),
(5, '陶俊华', '前端'),
(6, '曹方毅', '服务端/数据库'),
(7, '郑燕飞', '数据库'),
(8, '谢国良', '服务端'),
(9, '帅维城', '前端'),
(10, '陈苏熙', '前端/服务端'),
(11, '李欣', '服务端'),
(12, '王雪斌', '测试'),
(13, '钱星瑞', '测试'),
(14, '王然', '测试');

--
-- 转储表的索引
--

--
-- 表的索引 `chen_yaopu_review`
--
ALTER TABLE `chen_yaopu_review`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `review_record`
--
ALTER TABLE `review_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `record_id` (`record_id`);

--
-- 表的索引 `upgrade_record`
--
ALTER TABLE `upgrade_record`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `chen_yaopu_review`
--
ALTER TABLE `chen_yaopu_review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号';

--
-- 使用表AUTO_INCREMENT `review_record`
--
ALTER TABLE `review_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号';

--
-- 使用表AUTO_INCREMENT `upgrade_record`
--
ALTER TABLE `upgrade_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=15;

--
-- 限制导出的表
--

--
-- 限制表 `review_record`
--
ALTER TABLE `review_record`
  ADD CONSTRAINT `review_record_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `upgrade_record` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
