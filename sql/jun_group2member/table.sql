CREATE TABLE `jun_group2member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `member_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `role` varchar(255) DEFAULT NULL,
  `year_from` int(11) DEFAULT NULL,
  `year_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `jun_group2member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_id_2` (`group_id`,`member_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `member_id` (`member_id`);

ALTER TABLE `jun_group2member`
  ADD CONSTRAINT `jun_group2member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `artist` (`id`),
  ADD CONSTRAINT `jun_group2member_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `artist` (`id`);