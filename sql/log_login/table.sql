CREATE TABLE `log_login` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` BINARY(16) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `result` ENUM('success','failure') NOT NULL,
  `time` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `log_login`
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `result` (`result`);
