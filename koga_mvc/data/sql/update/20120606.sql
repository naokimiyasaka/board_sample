CREATE TABLE `repository_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_master_id` int(11) NOT NULL,
  `release_version` text NOT NULL,
  `development_version` text NOT NULL,
  `note` text NOT NULL,
  `preferred_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `test_revision` int(11) NOT NULL,
  `release_revision` int(11) NOT NULL,
  `application_server` text NOT NULL,
  `invalid_flg` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;
