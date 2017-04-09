CREATE TABLE `artist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('person','pseudonym','group') NOT NULL DEFAULT 'person',
  `artist_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `country_id` int(11) unsigned DEFAULT NULL,
  `year_from` year(4) DEFAULT NULL,
  `year_to` year(4) DEFAULT NULL,
  `description` text,
  `image_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nationality` (`country_id`),
  ADD KEY `type` (`type`),
  ADD KEY `person_id` (`artist_id`),
  ADD FULLTEXT KEY `fulltext` (`name`,`middlename`,`surname`);

ALTER TABLE `artist`
  ADD CONSTRAINT `artist_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `def_country` (`id`),
  ADD CONSTRAINT `artist_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`);
