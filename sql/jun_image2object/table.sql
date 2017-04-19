CREATE TABLE `jun_image2object` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(11) unsigned NOT NULL,
  `entity_id` int(11) unsigned DEFAULT NULL,
  `artist_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `jun_image2object`
  ADD UNIQUE KEY `entity_unique` (`image_id`,`entity_id`),
  ADD UNIQUE KEY `artist_unique` (`image_id`,`artist_id`),
  ADD UNIQUE KEY `user_unique` (`image_id`,`user_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `jun_image2object`
  ADD CONSTRAINT `jun_image2object_fk_1` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `jun_image2object_fk_2` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `jun_image2object_fk_3` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `jun_image2object_fk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT;
