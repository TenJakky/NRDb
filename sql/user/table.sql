CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` enum('user','moderator','administrator') NOT NULL DEFAULT 'user',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `country_id` int(11) unsigned NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `description` text,
  `per_page` int(11) unsigned NOT NULL DEFAULT '10',
  `per_page_small` int(11) unsigned NOT NULL DEFAULT '5',
  `ratings_total` int(10) unsigned NOT NULL DEFAULT '0',
  `ratings_movie` int(10) unsigned NOT NULL DEFAULT '0',
  `ratings_series` int(10) unsigned NOT NULL DEFAULT '0',
  `ratings_season` int(10) unsigned NOT NULL DEFAULT '0',
  `ratings_book` int(10) unsigned NOT NULL DEFAULT '0',
  `ratings_music` int(10) unsigned NOT NULL DEFAULT '0',
  `ratings_game` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `nationality` (`country_id`),
  ADD KEY `ratings_total` (`ratings_total`),
  ADD KEY `ratings_movie` (`ratings_movie`),
  ADD KEY `ratings_game` (`ratings_game`),
  ADD KEY `ratings_music` (`ratings_music`),
  ADD KEY `ratings_book` (`ratings_book`),
  ADD KEY `ratings_season` (`ratings_season`),
  ADD KEY `ratings_series` (`ratings_series`);

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `def_country` (`id`);
