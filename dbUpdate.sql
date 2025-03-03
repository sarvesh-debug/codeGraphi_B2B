CREATE TABLE `map_commission_plan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from_rt_count` int DEFAULT NULL,
  `to_rt_count` int DEFAULT NULL,
  `charge_in` varchar(50) DEFAULT NULL,
  `charge` float DEFAULT NULL,
  `tds_in` varchar(50) DEFAULT NULL,
  `tds` float DEFAULT NULL,
  `commission_in` varchar(50) DEFAULT NULL,
  `commission` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);