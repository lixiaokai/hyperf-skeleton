-- 导出  表 multi-tenant.app 结构
CREATE TABLE IF NOT EXISTS `app` (
  `id` varchar(20) NOT NULL COMMENT '应用 ID',
  `user_type` varchar(20) NOT NULL DEFAULT 'admin' COMMENT '用户类型',
  `name` varchar(20) NOT NULL COMMENT '应用名称',
  `desc` varchar(250) NOT NULL DEFAULT '' COMMENT '应用描述',
  `data` json DEFAULT NULL COMMENT '应用数据 Json',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='应用表';

-- 正在导出表  multi-tenant.app 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `app` DISABLE KEYS */;
INSERT INTO `app` (`id`, `user_type`, `name`, `desc`, `data`, `sort`, `created_at`, `updated_at`) VALUES
	('admin', 'admin', '总后台应用', '', NULL, 99, '2023-03-26 18:00:21', '2023-03-26 19:19:54'),
	('erp', 'admin', 'ERP 应用', '', NULL, 99, '2023-03-26 19:22:32', '2023-03-26 19:22:32');
/*!40000 ALTER TABLE `app` ENABLE KEYS */;

-- 导出  表 multi-tenant.app_tenant 结构
CREATE TABLE IF NOT EXISTS `app_tenant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `app_id` varchar(20) NOT NULL COMMENT '应用 ID',
  `tenant_id` int(10) unsigned NOT NULL COMMENT '租户 ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_id_tenant_id` (`app_id`,`tenant_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='应用和租户关系表';

-- 正在导出表  multi-tenant.app_tenant 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `app_tenant` DISABLE KEYS */;
INSERT INTO `app_tenant` (`id`, `app_id`, `tenant_id`, `created_at`) VALUES
	(1, 'admin', 1, '2023-03-26 19:22:44');
/*!40000 ALTER TABLE `app_tenant` ENABLE KEYS */;

-- 导出  表 multi-tenant.app_user 结构
CREATE TABLE IF NOT EXISTS `app_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `app_id` varchar(20) NOT NULL COMMENT '应用 ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户 ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `app_id_user_id` (`app_id`,`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='租户用户关系表';

-- 正在导出表  multi-tenant.app_user 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;
INSERT INTO `app_user` (`id`, `app_id`, `user_id`, `created_at`) VALUES
	(1, 'admin', 1, '2023-03-28 18:53:49'),
	(7, 'admin', 13, '2023-03-28 21:50:24'),
	(8, 'admin', 15, '2023-03-28 23:24:10'),
	(9, 'admin', 19, '2023-03-29 02:00:07');
/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;

-- 导出  表 multi-tenant.menu 结构
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限菜单 ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父 ID',
  `app_id` varchar(20) NOT NULL DEFAULT 'admin' COMMENT '应用 ID',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '前端路由',
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '后端路由',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `desc` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `status` varchar(20) NOT NULL DEFAULT 'enable' COMMENT '状态 ( enable-启用 disabled-禁用 )',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '999' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

-- 正在导出表  multi-tenant.menu 的数据：~7 rows (大约)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `parent_id`, `app_id`, `path`, `route`, `name`, `desc`, `icon`, `status`, `sort`, `created_at`, `updated_at`) VALUES
	(1, 0, 'admin', '/home', '/', '首页', '', '', 'enable', 999, '2023-02-25 06:48:22', '2023-03-21 01:04:18'),
	(2, 0, 'admin', '', 'GET:/admin/setting', '设置', '', '', 'enable', 999, '2023-02-25 06:48:29', '2023-03-21 01:06:45'),
	(3, 0, 'admin', '', 'GET:/admin/rbac/permission', '权限', '', '', 'enable', 999, '2023-02-25 06:48:35', '2023-03-21 01:04:25'),
	(4, 3, 'admin', '', 'GET:/admin/rbac/admin', '用户管理', '', '', 'enable', 999, '2023-02-25 06:48:48', '2023-02-25 06:50:36'),
	(5, 3, 'admin', '', 'GET:/admin/rbac/role', '角色管理', '', '', 'enable', 999, '2023-02-25 06:48:59', '2023-03-19 18:19:28'),
	(6, 3, 'admin', '', 'GET:/admin/rbac/permission', '权限管理', '', '', 'enable', 999, '2023-02-25 06:49:16', '2023-03-19 18:19:36'),
	(7, 3, 'admin', '', 'GET:/admin/rbac/menu', '菜单管理', '', '', 'enable', 999, '2023-02-25 06:49:24', '2023-03-28 18:41:25');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- 导出  表 multi-tenant.permission 结构
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限 ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父 ID',
  `app_id` varchar(20) NOT NULL DEFAULT 'admin' COMMENT '应用 ID',
  `route` varchar(250) NOT NULL COMMENT '路由 ( method + route 组成 )',
  `attach_routes` json DEFAULT NULL COMMENT '附加路由',
  `name` varchar(250) NOT NULL DEFAULT '' COMMENT '名称',
  `desc` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '999' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间 ( 软删除 )',
  PRIMARY KEY (`id`),
  UNIQUE KEY `route` (`route`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

-- 正在导出表  multi-tenant.permission 的数据：~45 rows (大约)
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` (`id`, `parent_id`, `app_id`, `route`, `attach_routes`, `name`, `desc`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 0, 'admin', 'POST:/admin/common/file/upload', '[]', '', '文件 - 上传', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(2, 0, 'admin', 'GET:/admin/common/menu', '[]', '', '菜单 - 列表 ( 树 )', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(3, 0, 'admin', 'PUT:/admin/common/profile/change-phone', '[]', '', '我的 - 更换手机号', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(4, 0, 'admin', 'PUT:/admin/common/profile/reset-password', '[]', '', '我的 - 修改密码', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(5, 0, 'admin', 'GET:/admin/common/profile', '[]', '', '我的 - 详情', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(6, 0, 'admin', 'PUT:/admin/common/profile/change-phone-sms-send', '[]', '', '我的 - 更换手机号 - 发送验证码', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(7, 0, 'admin', 'POST:/admin/common/user-admin/refresh-token', '[]', '', '刷新令牌', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(8, 0, 'admin', 'POST:/admin/public/auth/account-login', '[]', '', '账号 - 登录', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(9, 0, 'admin', 'POST:/admin/public/auth/sms-login', '[]', '', '验证码 - 登录', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(10, 0, 'admin', 'POST:/admin/public/auth/sms-send', '[]', '', '验证码 - 发送', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(11, 0, 'admin', 'POST:/admin/rbac/menu', '[]', '', '菜单管理 - 创建', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(12, 0, 'admin', 'DELETE:/admin/rbac/menu/{id}', '[]', '', '菜单管理 - 删除', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(13, 0, 'admin', 'PUT:/admin/rbac/menu/{id}/disable', '[]', '', '菜单管理 - 禁用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(14, 0, 'admin', 'PUT:/admin/rbac/menu/{id}/enable', '[]', '', '菜单管理 - 启用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(15, 0, 'admin', 'GET:/admin/rbac/menu', '[]', '', '菜单管理 - 列表', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(16, 0, 'admin', 'GET:/admin/rbac/menu/{id}', '[]', '', '菜单管理 - 详情', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(17, 0, 'admin', 'PUT:/admin/rbac/menu/{id}', '[]', '', '菜单管理 - 修改', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(18, 0, 'admin', 'POST:/admin/rbac/permission', '[]', '', '权限管理 - 收集', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(19, 0, 'admin', 'DELETE:/admin/rbac/permission/{id}', '[]', '', '权限管理 - 删除', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(20, 0, 'admin', 'GET:/admin/rbac/permission', '[]', '', '权限管理 - 列表', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(21, 0, 'admin', 'GET:/admin/rbac/permission/{id}', '[]', '', '权限管理 - 详情', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(22, 0, 'admin', 'PUT:/admin/rbac/permission/{id}', '[]', '', '权限管理 - 修改', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(23, 0, 'admin', 'PUT:/admin/rbac/role/{id}/bind-permission', '[]', '', '角色管理 - 设置权限', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(24, 0, 'admin', 'POST:/admin/rbac/role', '[]', '', '角色管理 - 创建', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(25, 0, 'admin', 'DELETE:/admin/rbac/role/{id}', '[]', '', '角色管理 - 删除', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(26, 0, 'admin', 'PUT:/admin/rbac/role/{id}/disable', '[]', '', '角色管理 - 禁用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(27, 0, 'admin', 'PUT:/admin/rbac/role/{id}/enable', '[]', '', '角色管理 - 启用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(28, 0, 'admin', 'GET:/admin/rbac/role', '[]', '', '角色管理 - 列表', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(29, 0, 'admin', 'GET:/admin/rbac/role/{id}', '[]', '', '角色管理 - 详情', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(30, 0, 'admin', 'PUT:/admin/rbac/role/{id}', '[]', '', '角色管理 - 修改', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(31, 0, 'admin', 'POST:/admin/rbac/user-admin', '[]', '', '用户管理 - 创建', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(32, 0, 'admin', 'DELETE:/admin/rbac/user-admin/{id}', '[]', '', '用户管理 - 删除', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(33, 0, 'admin', 'PUT:/admin/rbac/user-admin/{id}/disable', '[]', '', '用户管理 - 禁用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(34, 0, 'admin', 'PUT:/admin/rbac/user-admin/{id}/enable', '[]', '', '用户管理 - 启用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(35, 0, 'admin', 'GET:/admin/rbac/user-admin', '[]', '', '用户管理 - 列表', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(36, 0, 'admin', 'PUT:/admin/rbac/user-admin/{id}/reset-password', '[]', '', '用户管理 - 重置密码', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(37, 0, 'admin', 'GET:/admin/rbac/user-admin/{id}', '[]', '', '用户管理 - 详情', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(38, 0, 'admin', 'PUT:/admin/rbac/user-admin/{id}', '[]', '', '用户管理 - 修改', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(39, 0, 'demo', 'POST:/demo/test', '[]', '', '测试 - 创建', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(40, 0, 'demo', 'DELETE:/demo/test/{id}', '[]', '', '测试 - 删除', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(41, 0, 'demo', 'PUT:/demo/test/{id}/disable', '[]', '', '测试 - 禁用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(42, 0, 'demo', 'PUT:/demo/test/{id}/enable', '[]', '', '测试 - 启用', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(43, 0, 'demo', 'GET:/demo/test', '[]', '', '测试 - 列表', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(44, 0, 'demo', 'GET:/demo/test/{id}', '[]', '', '测试 - 详情', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL),
	(45, 0, 'demo', 'PUT:/demo/test/{id}', '[]', '', '测试 - 修改', 999, '2023-03-26 21:38:16', '2023-03-27 01:13:55', NULL);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;

-- 导出  表 multi-tenant.role 结构
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色 ID',
  `type` varchar(20) NOT NULL DEFAULT 'system' COMMENT '类型 ( system-系统角色 custom-自定义角色 )',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` varchar(20) NOT NULL DEFAULT 'enable' COMMENT '状态 ( enable-启用 disable-禁用 )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- 正在导出表  multi-tenant.role 的数据：~5 rows (大约)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `type`, `name`, `remark`, `sort`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'system', '超级管理员', '', 99, 'enable', '2023-03-26 19:19:04', '2023-03-27 00:40:46'),
	(2, 'system', '角色A', '', 99, 'enable', '2023-03-26 19:23:14', '2023-03-28 21:49:00'),
	(3, 'custom', '角色B', '', 99, 'enable', '2023-03-26 19:24:01', '2023-03-28 21:49:04'),
	(4, 'custom', '角色C', '', 99, 'enable', '2023-03-27 00:02:42', '2023-03-28 21:49:08'),
	(5, 'custom', '角色D', '', 99, 'enable', '2023-03-27 22:35:46', '2023-03-28 21:49:12');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- 导出  表 multi-tenant.role_permission 结构
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色 ID',
  `permission_id` int(10) unsigned NOT NULL COMMENT '权限 ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id_permission_id` (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COMMENT='角色权限关系表';

-- 正在导出表  multi-tenant.role_permission 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `created_at`) VALUES
	(9, 1, 9, '2023-03-20 00:21:40'),
	(10, 1, 10, '2023-03-20 00:21:40'),
	(11, 1, 14, '2023-03-20 00:21:40'),
	(12, 1, 15, '2023-03-20 00:21:40');
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;

-- 导出  表 multi-tenant.role_user 结构
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色 ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户 ID',
  `tenant_id` int(10) unsigned NOT NULL COMMENT '租户 ID ( 冗余 )',
  `app_id` varchar(20) NOT NULL COMMENT '应用 ID ( 冗余 )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id_user_id` (`role_id`,`user_id`) USING BTREE,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COMMENT='角色用户关系表';

-- 正在导出表  multi-tenant.role_user 的数据：~5 rows (大约)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `tenant_id`, `app_id`, `created_at`) VALUES
	(1, 1, 1, 1, 'admin', '2023-03-26 21:56:25'),
	(18, 2, 13, 1, 'admin', '2023-03-28 21:50:24'),
	(19, 3, 13, 1, 'admin', '2023-03-28 21:50:24'),
	(20, 2, 15, 1, 'admin', '2023-03-28 23:24:10'),
	(21, 2, 19, 1, 'admin', '2023-03-29 02:00:07');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;

-- 导出  表 multi-tenant.tenant 结构
CREATE TABLE IF NOT EXISTS `tenant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '租户 ID',
  `name` varchar(250) NOT NULL COMMENT '租户名称',
  `data` json DEFAULT NULL COMMENT '租户数据',
  `status` varchar(20) NOT NULL DEFAULT 'waitInit' COMMENT '状态 ( init-初始化 enable-启用 disable-禁用 )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='租户表';

-- 正在导出表  multi-tenant.tenant 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `tenant` DISABLE KEYS */;
INSERT INTO `tenant` (`id`, `name`, `data`, `status`, `created_at`, `updated_at`) VALUES
	(1, '平台公司', NULL, 'enable', '2023-03-26 19:19:32', '2023-03-26 19:19:40'),
	(2, '公司A', NULL, 'enable', '2023-03-26 19:22:11', '2023-03-26 19:22:11');
/*!40000 ALTER TABLE `tenant` ENABLE KEYS */;

-- 导出  表 multi-tenant.tenant_role 结构
CREATE TABLE IF NOT EXISTS `tenant_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `tenant_id` int(10) unsigned NOT NULL COMMENT '租户 ID',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色 ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `tenant_id_role_id` (`tenant_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='租户和角色关联表';

-- 正在导出表  multi-tenant.tenant_role 的数据：~5 rows (大约)
/*!40000 ALTER TABLE `tenant_role` DISABLE KEYS */;
INSERT INTO `tenant_role` (`id`, `tenant_id`, `role_id`, `created_at`) VALUES
	(3, 1, 1, '2023-03-26 19:32:04'),
	(8, 1, 2, '2023-03-28 21:49:24'),
	(9, 1, 3, '2023-03-28 21:49:29'),
	(10, 1, 4, '2023-03-28 21:49:35'),
	(11, 1, 5, '2023-03-28 21:49:39');
/*!40000 ALTER TABLE `tenant_role` ENABLE KEYS */;

-- 导出  表 multi-tenant.tenant_user 结构
CREATE TABLE IF NOT EXISTS `tenant_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `tenant_id` int(10) unsigned NOT NULL COMMENT '租户 ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户 ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenant_id_user_id` (`tenant_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='租户和用户关系表';

-- 正在导出表  multi-tenant.tenant_user 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `tenant_user` DISABLE KEYS */;
INSERT INTO `tenant_user` (`id`, `tenant_id`, `user_id`, `created_at`) VALUES
	(1, 1, 1, '2023-01-08 08:03:07'),
	(3, 1, 13, '2023-03-28 21:50:24'),
	(4, 1, 15, '2023-03-28 23:24:10'),
	(5, 1, 19, '2023-03-29 02:00:07');
/*!40000 ALTER TABLE `tenant_user` ENABLE KEYS */;

-- 导出  表 multi-tenant.user 结构
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户 ID',
  `username` varchar(50) NOT NULL COMMENT '用户账号',
  `nickname` varchar(50) DEFAULT NULL COMMENT '用户昵称',
  `phone` char(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `status` varchar(20) NOT NULL DEFAULT 'enable' COMMENT '状态 ( enable-启用 disable-禁用 )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- 正在导出表  multi-tenant.user 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `nickname`, `phone`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '超管', '13800138000', NULL, 'enable', '2023-03-15 17:32:18', '2023-03-29 01:41:23'),
	(13, 'user1', '用户1', '13800138001', NULL, 'enable', '2023-03-28 21:50:24', '2023-03-29 01:41:28'),
	(15, 'user2', '用户2', '13800138002', NULL, 'enable', '2023-03-28 23:24:10', '2023-03-29 01:41:31'),
	(19, 'user3', '用户3', '13800138003', NULL, 'enable', '2023-03-29 02:00:07', '2023-03-29 02:00:07');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- 导出  表 multi-tenant.user_admin 结构
CREATE TABLE IF NOT EXISTS `user_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户 ID',
  `username` varchar(50) NOT NULL COMMENT '用户账号',
  `nickname` varchar(50) DEFAULT NULL COMMENT '用户昵称',
  `phone` char(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `status` varchar(20) NOT NULL DEFAULT 'enable' COMMENT '状态 ( enable-启用 disable-禁用 )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COMMENT='总后台用户表';

-- 正在导出表  multi-tenant.user_admin 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `user_admin` DISABLE KEYS */;
INSERT INTO `user_admin` (`id`, `username`, `nickname`, `phone`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '超管', '13800138000', NULL, 'enable', '2023-03-22 19:10:14', '2023-03-29 02:00:34'),
	(13, 'user1', '用户1', '13800138001', NULL, 'enable', '2023-03-28 21:50:24', '2023-03-29 02:00:30'),
	(15, 'user2', '用户2', '13800138002', NULL, 'enable', '2023-03-28 23:24:10', '2023-03-29 02:00:27'),
	(19, 'user3', '用户3', '13800138003', NULL, 'enable', '2023-03-29 02:00:07', '2023-03-29 02:00:07');
/*!40000 ALTER TABLE `user_admin` ENABLE KEYS */;

-- 导出  表 multi-tenant.user_auth 结构
CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户 ID',
  `type` varchar(50) NOT NULL COMMENT '授权类型',
  `identifier` varchar(50) DEFAULT NULL COMMENT '身份标识',
  `credential` varchar(255) DEFAULT NULL COMMENT '授权凭证 ( 本地密码 | 第三方 token )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_type` (`user_id`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='用户授权表';

-- 正在导出表  multi-tenant.user_auth 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `user_auth` DISABLE KEYS */;
INSERT INTO `user_auth` (`id`, `user_id`, `type`, `identifier`, `credential`, `created_at`, `updated_at`) VALUES
	(1, 1, 'pwd', NULL, '$2y$10$5wMUlVm9uw.vL.NHGaOh.uNhnCuIEzrx6vltqTN5.dPKOfsA3.RKq', '2023-03-28 22:37:23', '2023-03-28 22:37:30'),
	(2, 13, 'pwd', NULL, '$2y$10$5wMUlVm9uw.vL.NHGaOh.uNhnCuIEzrx6vltqTN5.dPKOfsA3.RKq', '2023-03-28 22:37:46', '2023-03-28 23:24:45'),
	(3, 15, 'pwd', NULL, '$2y$10$QQ3t2X4o3b4qmpb4Bz2vcuN.Z5XyYRQ9fcJ7P9YmmaUfTipaWrT9W', '2023-03-28 23:24:10', '2023-03-28 23:24:10'),
	(7, 19, 'pwd', NULL, '$2y$10$cws7DFJLYrp5lWRM39I.Revu0RS7MHebd.1ytsPCoDTm8pQ.LtF62', '2023-03-29 02:00:07', '2023-03-29 02:00:07');
/*!40000 ALTER TABLE `user_auth` ENABLE KEYS */;

-- 导出  表 multi-tenant._test 结构
CREATE TABLE IF NOT EXISTS `_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增 ID',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `phone` char(11) NOT NULL COMMENT '手机号',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `status` varchar(20) NOT NULL DEFAULT 'enable' COMMENT '状态 ( enable-启用 disable-禁用 )',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间 ( 软删除 )',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='测试表';

-- 正在导出表  multi-tenant._test 的数据：~13 rows (大约)
/*!40000 ALTER TABLE `_test` DISABLE KEYS */;
INSERT INTO `_test` (`id`, `name`, `phone`, `password`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'user1', '13800138000', '12345678', 'enable', '2023-03-10 06:38:17', '2023-03-10 00:49:08', NULL),
	(2, 'user2', '13800138001', NULL, 'enable', '2023-03-10 06:38:39', '2023-03-10 06:38:39', NULL),
	(3, 'user', '13800138000', '123456', 'enable', '2023-03-09 23:53:54', '2023-03-09 23:53:54', NULL),
	(4, 'user', '13800138000', '123456', 'enable', '2023-03-09 23:54:39', '2023-03-09 23:54:39', NULL),
	(5, 'user', '13800138000', '123456', 'enable', '2023-03-09 23:56:10', '2023-03-09 23:56:10', NULL),
	(6, 'user', '13800138000', '123456', 'enable', '2023-03-10 00:01:12', '2023-03-10 00:01:12', NULL),
	(7, 'user', '13800138000', '123456', 'enable', '2023-03-10 00:06:03', '2023-03-10 00:06:03', NULL),
	(8, 'user', '13800138000', '123456', 'enable', '2023-03-10 00:09:38', '2023-03-10 00:09:38', NULL),
	(9, 'user', '13800138000', '123456', 'enable', '2023-03-10 00:12:42', '2023-03-10 00:12:42', NULL),
	(10, 'user', '13800138000', '123456', 'enable', '2023-03-10 00:16:35', '2023-03-10 00:16:35', NULL),
	(11, 'user', '13800138000', '123456', 'enable', '2023-03-10 00:21:45', '2023-03-10 00:21:45', NULL),
	(12, 'user', '13800138000', '123456', 'enable', '2023-03-10 01:32:30', '2023-03-10 01:32:30', NULL),
	(13, 'user', '13800138000', '123456', 'enable', '2023-03-10 01:37:50', '2023-03-10 01:37:50', NULL);
/*!40000 ALTER TABLE `_test` ENABLE KEYS */;
