CREATE TABLE `image` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `filename` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
