CREATE TABLE IF NOT EXISTS `fa_invite_code` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL,
  `inviter_user_id` int unsigned NOT NULL,
  `used_by_user_id` int unsigned DEFAULT NULL,
  `status` enum('unused','used','disabled') NOT NULL DEFAULT 'unused',
  `expire_time` bigint unsigned DEFAULT NULL,
  `used_time` bigint unsigned DEFAULT NULL,
  `createtime` bigint NOT NULL DEFAULT '0',
  `updatetime` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`),
  KEY `idx_inviter` (`inviter_user_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `fa_user`
  ADD COLUMN `inviter_user_id` int unsigned NULL AFTER `verification`;
