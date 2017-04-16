CREATE TABLE `entity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('movie','series','season','book','music','game') NOT NULL,
  `original_title` varchar(255) DEFAULT NULL,
  `english_title` varchar(255) DEFAULT NULL,
  `czech_title` varchar(255) DEFAULT NULL,
  `description` text,
  `year` year(4) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `series_active` tinyint(1) unsigned DEFAULT NULL,
  `season_series_id` int(11) unsigned DEFAULT NULL,
  `season_number` int(11) unsigned DEFAULT NULL,
  `rating_count` int(11) unsigned NOT NULL,
  `rating_sum` int(11) unsigned NOT NULL,
  `rating` double unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `year` (`year`),
  ADD KEY `season_series_id` (`season_series_id`),
  ADD KEY `rating` (`rating`);

ALTER TABLE `entity`
  ADD CONSTRAINT `entity_ibfk_1` FOREIGN KEY (`season_series_id`) REFERENCES `entity` (`id`);
