DELIMITER //

CREATE TRIGGER `rating_after_insert`
AFTER INSERT ON `rating`
FOR EACH ROW
  BEGIN

    DECLARE var_type ENUM('movie', 'series', 'season', 'book', 'music',	'game');
    DECLARE var_id INT;

    SELECT id, type INTO var_id, var_type
    FROM entity
    WHERE id = NEW.entity_id;

    CASE var_type
      WHEN 'movie' THEN
      UPDATE `user`
      SET ratings_movie = ratings_movie + 1, ratings_total = ratings_total + 1
      WHERE id = NEW.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` + 1, movie_count = movie_count + 1
      WHERE `value` = NEW.value;
      WHEN 'series' THEN
      UPDATE `user`
      SET ratings_series = ratings_series + 1, ratings_total = ratings_total + 1
      WHERE id = NEW.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` + 1, series_count = series_count + 1
      WHERE  `value` = NEW.value;
      WHEN 'season' THEN
      UPDATE `user`
      SET ratings_season = ratings_season + 1, ratings_total = ratings_total + 1
      WHERE id = NEW.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` + 1, season_count = season_count + 1
      WHERE  `value` = NEW.value;
      WHEN 'book' THEN
      UPDATE `user`
      SET ratings_book = ratings_book + 1, ratings_total = ratings_total + 1
      WHERE id = NEW.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` + 1, book_count = book_count + 1
      WHERE  `value` = NEW.value;
      WHEN 'music' THEN
      UPDATE `user`
      SET ratings_music = ratings_music + 1, ratings_total = ratings_total + 1
      WHERE id = NEW.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` + 1, music_count = music_count + 1
      WHERE  `value` = NEW.value;
      WHEN 'game' THEN
      UPDATE `user`
      SET ratings_game = ratings_game + 1, ratings_total = ratings_total + 1
      WHERE id = NEW.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` + 1, game_count = game_count + 1
      WHERE  `value` = NEW.value;
      ELSE BEGIN END;
    END CASE;

    UPDATE `entity`
    SET
      rating_count = rating_count + 1,
      rating_sum = rating_sum + NEW.value,
      rating = ((rating_sum + NEW.value) / (rating_count + 1))
    WHERE id = var_id;

    UPDATE `stat_entity`
    SET rating_count = rating_count + 1
    WHERE type = var_type;

  END//



CREATE TRIGGER `rating_after_delete`
AFTER DELETE ON `rating`
FOR EACH ROW
  BEGIN

    DECLARE var_type ENUM('movie', 'series', 'season', 'book', 'music',	'game');
    DECLARE var_id INT;

    SELECT id, type INTO var_id, var_type
    FROM entity
    WHERE id = OLD.entity_id;

    CASE var_type
      WHEN 'movie' THEN
      UPDATE `user`
      SET ratings_movie = ratings_movie - 1, ratings_total = ratings_total - 1
      WHERE id = OLD.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` - 1, movie_count = movie_count - 1
      WHERE `value` = OLD.value;
      WHEN 'series' THEN
      UPDATE `user`
      SET ratings_series = ratings_series - 1, ratings_total = ratings_total - 1
      WHERE id = OLD.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` - 1, series_count = series_count - 1
      WHERE  `value` = OLD.value;
      WHEN 'season' THEN
      UPDATE `user`
      SET ratings_season = ratings_season - 1, ratings_total = ratings_total - 1
      WHERE id = OLD.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` - 1, season_count = season_count - 1
      WHERE  `value` = OLD.value;
      WHEN 'book' THEN
      UPDATE `user`
      SET ratings_book = ratings_book - 1, ratings_total = ratings_total - 1
      WHERE id = OLD.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` - 1, book_count = book_count - 1
      WHERE  `value` = OLD.value;
      WHEN 'music' THEN
      UPDATE `user`
      SET ratings_music = ratings_music - 1, ratings_total = ratings_total - 1
      WHERE id = OLD.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` - 1, music_count = music_count - 1
      WHERE  `value` = OLD.value;
      WHEN 'game' THEN
      UPDATE `user`
      SET ratings_game = ratings_game - 1, ratings_total = ratings_total - 1
      WHERE id = OLD.user_id;
      UPDATE `stat_rating`
      SET `count` = `count` - 1, game_count = game_count - 1
      WHERE  `value` = OLD.value;
      ELSE BEGIN END;
    END CASE;

    UPDATE `entity`
    SET
      rating_count = rating_count - 1,
      rating_sum = rating_sum - OLD.value,
      rating = (CASE rating_count WHEN 1 THEN 0 ELSE ((rating_sum - NEW.value) / (rating_count - 1)) END)
    WHERE id = var_id;

    UPDATE `stat_entity`
    SET rating_count = rating_count - 1
    WHERE type = var_type;

  END//

DELIMITER ;
