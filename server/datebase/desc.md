# 数据库文档

## 数据库账号信息
账号 | 密码
---|---
Record | Record123

---

## 升级记录表
序号 | 国家 | 升级内容 | 更新时间(北京时间) | 更新人 | 测试人员 | 类型 | 前后端 | 复盘结论 | 备注
---|---|---|---|---|---|---|---|---|---
1 | 美国 | 增加了更新记录 | 2020-03-12 15:30:30 | admin | admin | 1 | 无 | 无 | 

*注：*
- **类型分类：** `新功能`、`新游戏`、`bug修复`、`功能优化`
- **前后端分类：** `前端`、`后端`、`前后端`、`数据库`

---

## 用户信息表
序号 | 用户名 | 岗位
---|---|---
（待补充） | （待补充） | （待补充）

---

## 复盘记录表
序号 | 国家 | 记录表序号 | 复盘内容 | 复盘时间 | 复盘人 | 复盘结论 | 截图地址
---|---|---|---|---|---|---|---
（待补充） | （待补充） | （待补充） | （待补充） | （待补充） | （待补充） | （待补充） | 

## 陈堯朴复盘记录
序号 | 目的 | 会议发起人 | 参会人 | 结论 
---|---|---|---|---|---
（待补充） | （待补充） | （待补充） | （待补充） | （待补充） 



// ... 已有表结构 ...

-- 陈堯朴复盘记录表
CREATE TABLE `chen_yaopu_review` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '序号',
  `purpose` TEXT NOT NULL COMMENT '目的',
  `initiator` VARCHAR(50) NOT NULL COMMENT '会议发起人',
  `participants` TEXT NOT NULL COMMENT '参会人',
  `conclusion` TEXT NOT NULL COMMENT '结论'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='陈堯朴复盘记录';

// ... 后续其他表结构 ...

-- 升级记录表
CREATE TABLE `upgrade_record` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '序号',
  `country` VARCHAR(50) NOT NULL COMMENT '国家',
  `content` TEXT NOT NULL COMMENT '升级内容',
  `update_time` DATETIME NOT NULL COMMENT '更新时间(北京时间)',
  `updater` VARCHAR(50) NOT NULL COMMENT '更新人',
  `tester` VARCHAR(50) NOT NULL COMMENT '测试人员',
  `type` ENUM('新功能','新游戏','bug修复','功能优化') NOT NULL COMMENT '类型',
  `platform` ENUM('前端','后端','前后端','数据库') NOT NULL COMMENT '前后端',
  `review_conclusion` TEXT COMMENT '复盘结论',
  `remark` VARCHAR(500) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='升级记录表';

-- 用户信息表
CREATE TABLE `user` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '序号',
  `username` VARCHAR(50) NOT NULL UNIQUE COMMENT '用户名',
  `position` VARCHAR(100) NOT NULL COMMENT '岗位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户信息表';

-- 复盘记录表
CREATE TABLE `review_record` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '序号',
  `country` VARCHAR(50) NOT NULL COMMENT '国家',
  `record_id` INT UNSIGNED NOT NULL COMMENT '关联升级记录表ID',
  `review_content` TEXT NOT NULL COMMENT '复盘内容',
  `review_time` DATETIME NOT NULL COMMENT '复盘时间',
  `reviewer` VARCHAR(50) NOT NULL COMMENT '复盘人',
  `conclusion` TEXT NOT NULL COMMENT '复盘结论',
  `screenshot_url` VARCHAR(500) DEFAULT NULL COMMENT '截图地址',
  FOREIGN KEY (`record_id`) REFERENCES `upgrade_record` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='复盘记录表';