CREATE TABLE `stat_rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` smallint(6) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `movie_count` int(11) unsigned NOT NULL DEFAULT '0',
  `series_count` int(11) unsigned NOT NULL DEFAULT '0',
  `season_count` int(11) unsigned NOT NULL DEFAULT '0',
  `book_count` int(11) unsigned NOT NULL DEFAULT '0',
  `music_count` int(11) unsigned NOT NULL DEFAULT '0',
  `game_count` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `stat_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `value` (`value`);
