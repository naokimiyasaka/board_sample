CREATE TABLE `repository_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `name` text NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `repository_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `repository_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_storage_id` int(11) NOT NULL,
  `repository_contents_id` int(11) NOT NULL,
  `repository_company_id` int(11) NOT NULL,
  `repository_type_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `repository_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `repository_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `user_post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `user_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

CREATE TABLE `user_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `repository_master_id` int(11) NOT NULL,
  `send_flg` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;

insert into `repository_company` (`id`, `code`, `name`, `memo`) values (1, 'GJP', 'ガマニア日本', '') ;
insert into `repository_company` (`id`, `code`, `name`, `memo`) values (2, 'GKR', 'ガマニア韓国', '') ;

insert into `repository_contents` (`id`, `code`, `name`) values (1, 'KS', 'キングダムサーガ') ;
insert into `repository_contents` (`id`, `code`, `name`) values (2, 'KH', 'Web恋姫†無双') ;
insert into `repository_contents` (`id`, `code`, `name`) values (3, 'WPD', 'Webパワードール') ;
insert into `repository_contents` (`id`, `code`, `name`) values (4, 'PB', 'Webファントム・ブレイブ') ;
insert into `repository_contents` (`id`, `code`, `name`) values (5, 'KC', 'Webナイトカーニバル') ;
insert into `repository_contents` (`id`, `code`, `name`) values (6, 'LT', 'ラングリッサー・トライソード') ;
insert into `repository_contents` (`id`, `code`, `name`) values (7, 'KHG', '恋姫†無双EXA') ;
insert into `repository_contents` (`id`, `code`, `name`) values (8, 'KCG', 'ナイトカーニバルGREE') ;

insert into `repository_storage` (`id`, `name`, `memo`) values (1, 'staging', '検収前') ;
insert into `repository_storage` (`id`, `name`, `memo`) values (2, 'production', '検収後') ;

insert into `repository_type` (`id`, `name`) values (1, 'game') ;
insert into `repository_type` (`id`, `name`) values (2, 'document') ;
insert into `repository_type` (`id`, `name`) values (3, 'tool') ;

insert into `user_post` (`id`, `code`, `name`) values (1, 'IT-DV', '技術開発部') ;
insert into `user_post` (`id`, `code`, `name`) values (2, 'IT-NW', 'ネットワーク部') ;
insert into `user_post` (`id`, `code`, `name`) values (3, 'OS', '運営') ;
insert into `user_post` (`id`, `code`, `name`) values (4, 'PS', 'プラットフォーム戦略部') ;
insert into `user_post` (`id`, `code`, `name`) values (5, 'PDS', '企画開発課') ;
insert into `user_post` (`id`, `code`, `name`) values (6, 'PSS', '開発支援課') ;
insert into `user_post` (`id`, `code`, `name`) values (7, 'QA', 'QA課') ;
