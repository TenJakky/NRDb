CREATE TABLE `rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned NOT NULL,
  `value` smallint(6) unsigned NOT NULL,
  `note` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `rating`
  ADD UNIQUE KEY `user_id_2` (`user_id`,`entity_id`),
  ADD KEY `date` (`date`),
  ADD KEY `value` (`value`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `entity_id` (`entity_id`);

ALTER TABLE `rating`
  ADD CONSTRAINT `rating_fk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `rating_fk_2` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE RESTRICT;
