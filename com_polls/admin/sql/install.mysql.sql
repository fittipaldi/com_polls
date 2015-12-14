DROP TABLE IF EXISTS `#__polls_answers`;
CREATE TABLE IF NOT EXISTS `#__polls_answers` (
  `polls_answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `polls_item_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`polls_answer_id`),
  UNIQUE KEY `polls_answer_id_UNIQUE` (`polls_answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__polls_items`;
CREATE TABLE IF NOT EXISTS `#__polls_items` (
  `polls_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text,
  `state` char(1) DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`polls_item_id`),
  UNIQUE KEY `polls_item_id_UNIQUE` (`polls_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__polls_votes`;
CREATE TABLE IF NOT EXISTS `#__polls_votes` (
  `polls_vote_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `polls_answer_id` int(11) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`polls_vote_id`),
  UNIQUE KEY `polls_vote_id_UNIQUE` (`polls_vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
) ENGINE=MyISAM DEFAULT CHARSET=utf8;