/* NRDb SQL script */

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `NRDb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `NRDb`;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `adm_introduction`;
CREATE TABLE IF NOT EXISTS `adm_introduction` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `adm_news`;
CREATE TABLE IF NOT EXISTS `adm_news` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `def_changelog`;
CREATE TABLE IF NOT EXISTS `def_changelog` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `version` varchar(255) NOT NULL,
  `major` tinyint(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `def_country`;
CREATE TABLE IF NOT EXISTS `def_country` (
  `id` int(11) NOT NULL,
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `ent_book`;
CREATE TABLE IF NOT EXISTS `ent_book` (
  `id` int(11) NOT NULL,
  `original_title` varchar(255) NOT NULL,
  `english_title` varchar(255) NOT NULL,
  `czech_title` varchar(255) DEFAULT NULL,
  `description` text,
  `year` int(11) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ent_game`;
CREATE TABLE IF NOT EXISTS `ent_game` (
  `id` int(11) NOT NULL,
  `original_title` varchar(255) NOT NULL,
  `description` text,
  `year` int(11) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ent_movie`;
CREATE TABLE IF NOT EXISTS `ent_movie` (
  `id` int(11) NOT NULL,
  `original_title` varchar(255) NOT NULL,
  `english_title` varchar(255) NOT NULL,
  `czech_title` varchar(255) DEFAULT NULL,
  `description` text,
  `year` int(11) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ent_music`;
CREATE TABLE IF NOT EXISTS `ent_music` (
  `id` int(11) NOT NULL,
  `original_title` varchar(45) NOT NULL,
  `description` text,
  `year` int(11) NOT NULL,
  `image_file` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ent_series`;
CREATE TABLE IF NOT EXISTS `ent_series` (
  `id` int(11) NOT NULL,
  `original_title` varchar(255) NOT NULL,
  `english_title` varchar(255) NOT NULL,
  `czech_title` varchar(255) DEFAULT NULL,
  `description` text,
  `image_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ent_series_season`;
CREATE TABLE IF NOT EXISTS `ent_series_season` (
  `id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `description` text,
  `poster_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `jun_book2author`;
CREATE TABLE IF NOT EXISTS `jun_book2author` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_game2developer`;
CREATE TABLE IF NOT EXISTS `jun_game2developer` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_group2member`;
CREATE TABLE IF NOT EXISTS `jun_group2member` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `year_from` int(11) DEFAULT NULL,
  `year_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_movie2actor`;
CREATE TABLE IF NOT EXISTS `jun_movie2actor` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_movie2director`;
CREATE TABLE IF NOT EXISTS `jun_movie2director` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_music2interpret`;
CREATE TABLE IF NOT EXISTS `jun_music2interpret` (
  `id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_series2actor`;
CREATE TABLE IF NOT EXISTS `jun_series2actor` (
  `id` int(11) NOT NULL,
  `series_season_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jun_series2director`;
CREATE TABLE IF NOT EXISTS `jun_series2director` (
  `id` int(11) NOT NULL,
  `series_season_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL,
  `type` enum('person','pseudonym') NOT NULL DEFAULT 'person',
  `person_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `died` date DEFAULT NULL,
  `description` text,
  `image_file` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL,
  `type` enum('band','studio') NOT NULL DEFAULT 'band',
  `name` varchar(255) NOT NULL,
  `year_from` int(11) DEFAULT NULL,
  `year_to` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `rating_book`;
CREATE TABLE IF NOT EXISTS `rating_book` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `note` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rating_game`;
CREATE TABLE IF NOT EXISTS `rating_game` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `note` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rating_movie`;
CREATE TABLE IF NOT EXISTS `rating_movie` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `note` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rating_music`;
CREATE TABLE IF NOT EXISTS `rating_music` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `note` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rating_series`;
CREATE TABLE IF NOT EXISTS `rating_series` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `series_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `note` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rating_series_season`;
CREATE TABLE IF NOT EXISTS `rating_series_season` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `series_season_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `note` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `role` enum('User','Moderator','Administrator') NOT NULL DEFAULT 'User',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `description` text,
  `per_page` int(11) NOT NULL DEFAULT '10',
  `per_page_small` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

ALTER TABLE `adm_introduction`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `adm_news`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

ALTER TABLE `def_changelog`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

ALTER TABLE `def_country`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

ALTER TABLE `ent_book`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ent_game`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ent_movie`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ent_music`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ent_series`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ent_series_season`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_id` (`series_id`) USING BTREE;

-- --------------------------------------------------------

ALTER TABLE `jun_book2author`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`) USING BTREE,
  ADD KEY `person_id` (`person_id`) USING BTREE;

ALTER TABLE `jun_game2developer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `group_id` (`group_id`) USING BTREE,
  ADD KEY `game_id` (`game_id`) USING BTREE;

ALTER TABLE `jun_group2member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `group_id` (`group_id`) USING BTREE;

ALTER TABLE `jun_movie2actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `movie_id` (`movie_id`);

ALTER TABLE `jun_movie2director`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`) USING BTREE,
  ADD KEY `person_id` (`person_id`) USING BTREE;

ALTER TABLE `jun_music2interpret`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `music_id` (`music_id`) USING BTREE,
  ADD KEY `group_id` (`group_id`) USING BTREE;

ALTER TABLE `jun_series2actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `series_id` (`series_season_id`) USING BTREE;

ALTER TABLE `jun_series2director`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_id` (`series_season_id`) USING BTREE,
  ADD KEY `person_id` (`person_id`) USING BTREE;

-- --------------------------------------------------------

ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nationality` (`country_id`),
  ADD KEY `type` (`type`),
  ADD KEY `person_id` (`person_id`);

ALTER TABLE `group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

-- --------------------------------------------------------

ALTER TABLE `rating_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `rating` (`rating`);

ALTER TABLE `rating_game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `rating` (`rating`);

ALTER TABLE `rating_movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `rating` (`rating`);

ALTER TABLE `rating_music`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rating` (`rating`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `music_id` (`music_id`) USING BTREE;

ALTER TABLE `rating_series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `series_id` (`series_id`),
  ADD KEY `rating` (`rating`);

ALTER TABLE `rating_series_season`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `rating` (`rating`) USING BTREE,
  ADD KEY `series_season_id` (`series_season_id`) USING BTREE;

-- --------------------------------------------------------

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nationality` (`country_id`);

-- --------------------------------------------------------

ALTER TABLE `adm_introduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `adm_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `def_changelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `def_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `ent_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ent_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ent_movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ent_music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ent_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ent_series_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `jun_book2author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_game2developer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_group2member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_movie2actor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_movie2director`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_music2interpret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_series2actor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jun_series2director`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `rating_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rating_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rating_movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rating_music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rating_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rating_series_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `ent_series_season`
  ADD CONSTRAINT `series_seasson_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `ent_series` (`id`);

-- --------------------------------------------------------

ALTER TABLE `jun_book2author`
  ADD CONSTRAINT `jun_book2author_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ent_book` (`id`),
  ADD CONSTRAINT `jun_book2author_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

ALTER TABLE `jun_game2developer`
  ADD CONSTRAINT `jun_game2developer_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `ent_game` (`id`),
  ADD CONSTRAINT `jun_game2developer_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `jun_game2developer_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`);

ALTER TABLE `jun_group2member`
  ADD CONSTRAINT `jun_group2member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`),
  ADD CONSTRAINT `jun_group2member_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

ALTER TABLE `jun_movie2actor`
  ADD CONSTRAINT `jun_movie2actor_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `ent_movie` (`id`),
  ADD CONSTRAINT `jun_movie2actor_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

ALTER TABLE `jun_movie2director`
  ADD CONSTRAINT `jun_movie2director_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `ent_movie` (`id`),
  ADD CONSTRAINT `jun_movie2director_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

ALTER TABLE `jun_music2interpret`
  ADD CONSTRAINT `jun_music2interpret_ibfk_1` FOREIGN KEY (`music_id`) REFERENCES `ent_music` (`id`),
  ADD CONSTRAINT `jun_music2interpret_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `jun_music2interpret_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`);

ALTER TABLE `jun_series2actor`
  ADD CONSTRAINT `jun_series2actor_ibfk_1` FOREIGN KEY (`series_season_id`) REFERENCES `ent_series_season` (`id`),
  ADD CONSTRAINT `jun_series2actor_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

ALTER TABLE `jun_series2director`
  ADD CONSTRAINT `jun_series2director_ibfk_1` FOREIGN KEY (`series_season_id`) REFERENCES `ent_series_season` (`id`),
  ADD CONSTRAINT `jun_series2director_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

-- --------------------------------------------------------

ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `def_country` (`id`);

-- --------------------------------------------------------

ALTER TABLE `rating_book`
  ADD CONSTRAINT `rating_book_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `rating_book_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ent_book` (`id`);

ALTER TABLE `rating_game`
  ADD CONSTRAINT `rating_game_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `rating_game_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `ent_game` (`id`);

ALTER TABLE `rating_movie`
  ADD CONSTRAINT `rating_movie_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `rating_movie_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `ent_movie` (`id`);

ALTER TABLE `rating_music`
  ADD CONSTRAINT `rating_music_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `rating_music_ibfk_2` FOREIGN KEY (`music_id`) REFERENCES `ent_music` (`id`);

ALTER TABLE `rating_series`
  ADD CONSTRAINT `rating_series_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `ent_series` (`id`),
  ADD CONSTRAINT `rating_series_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `rating_series_season`
  ADD CONSTRAINT `rating_series_season_ibfk_1` FOREIGN KEY (`series_season_id`) REFERENCES `ent_series_season` (`id`),
  ADD CONSTRAINT `rating_series_season_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

-- --------------------------------------------------------

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `def_country` (`id`);

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
