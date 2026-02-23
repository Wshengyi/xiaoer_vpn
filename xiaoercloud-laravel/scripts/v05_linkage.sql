ALTER TABLE `fa_subscription`
  ADD COLUMN IF NOT EXISTS `source_order_id` int unsigned NULL COMMENT '来源订单ID' AFTER `shadowrocket_url`,
  ADD UNIQUE KEY `uk_source_order_id` (`source_order_id`);
