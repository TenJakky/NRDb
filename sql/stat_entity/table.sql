CREATE TABLE `stat_entity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('movie','series','season','book','music','game') NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `stat_entity`
  ADD KEY `type` (`type`);
