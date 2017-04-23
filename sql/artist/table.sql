CREATE TABLE `artist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('person','pseudonym','group') NOT NULL DEFAULT 'person',
  `artist_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `country_id` int(11) unsigned DEFAULT NULL,
  `year_from` SMALLINT(4) unsigned DEFAULT NULL,
  `year_to` SMALLINT(4) unsigned DEFAULT NULL,
  `description` text,
  `image_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `artist`
  ADD KEY `country_id` (`country_id`),
  ADD KEY `type` (`type`),
  ADD KEY `person_id` (`artist_id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `artist`
  ADD CONSTRAINT `artist_fk_1` FOREIGN KEY (`country_id`) REFERENCES `def_country` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `artist_fk_2` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `artist_fk_3` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE RESTRICT;
