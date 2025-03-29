-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-03-29 10:43:20
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `record`
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
  `review_conclusion` text DEFAULT NULL COMMENT '复盘结论',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='升级记录表';

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
(1, 'yjj', 'jj'),
(2, '1', '2');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号';

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=3;

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
