CREATE TABLE `jun_artist2entity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) unsigned NOT NULL,
  `role` enum('actor','director','author','interpret','developer') NOT NULL,
  `entity_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `jun_artist2entity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artist_id_2` (`artist_id`,`role`,`entity_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `movie_id` (`entity_id`);

ALTER TABLE `jun_artist2entity`
  ADD CONSTRAINT `jun_artist2entity_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`),
  ADD CONSTRAINT `jun_artist2entity_ibfk_2` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`);
