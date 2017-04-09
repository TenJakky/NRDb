CREATE TABLE `def_changelog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `version` varchar(255) NOT NULL,
  `major` tinyint(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `def_changelog`
  ADD PRIMARY KEY (`id`);
