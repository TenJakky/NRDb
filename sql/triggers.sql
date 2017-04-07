# after update

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
      WHERE `user`.id = NEW.user_id;
    WHEN 'series' THEN
      UPDATE `user`
      SET ratings_series = ratings_series + 1, ratings_total = ratings_total + 1
      WHERE `user`.id = NEW.user_id;
    WHEN 'season' THEN
      UPDATE `user`
      SET ratings_season = ratings_season + 1, ratings_total = ratings_total + 1
      WHERE `user`.id = NEW.user_id;
    WHEN 'book'
    THEN
      UPDATE `user`
      SET ratings_book = ratings_book + 1, ratings_total = ratings_total + 1
      WHERE `user`.id = NEW.user_id;
    WHEN 'music' THEN
      UPDATE `user`
      SET ratings_music = ratings_music + 1, ratings_total = ratings_total + 1
      WHERE `user`.id = NEW.user_id;
    WHEN 'game' THEN
      UPDATE `user`
      SET ratings_game = ratings_game + 1, ratings_total = ratings_total + 1
      WHERE `user`.id = NEW.user_id;
  END CASE;

  UPDATE `entity`
  SET rating_count = rating_count + 1, rating_sum = rating_sum + NEW.value
  WHERE `entity`.id = var_id;

END//


# after delete

CREATE TRIGGER `rating_after_delete`
AFTER DELETE ON `rating`
FOR EACH ROW
BEGIN

  DECLARE var_type ENUM('movie', 'series', 'season', 'book', 'music',	'game');
  DECLARE var_id INT;

  SELECT id, type INTO var_id, var_type
  FROM entity
  WHERE id = NEW.entity_id;

  CASE (SELECT type FROM entity WHERE id = OLD.entity_id)
    WHEN 'movie' THEN
      UPDATE `user` SET ratings_movie = ratings_movie - 1, ratings_total = ratings_total - 1
      WHERE `user`.id = OLD.user_id;
    WHEN 'series' THEN
      UPDATE `user` SET ratings_series = ratings_series - 1, ratings_total = ratings_total - 1
      WHERE `user`.id = OLD.user_id;
    WHEN 'season' THEN
      UPDATE `user` SET ratings_season = ratings_season - 1, ratings_total = ratings_total - 1
      WHERE `user`.id = OLD.user_id;
    WHEN 'book' THEN
      UPDATE `user` SET ratings_book = ratings_book - 1, ratings_total = ratings_total - 1
      WHERE `user`.id = OLD.user_id;
    WHEN 'music' THEN
      UPDATE `user` SET ratings_music = ratings_music - 1, ratings_total = ratings_total - 1
      WHERE `user`.id = OLD.user_id;
    WHEN 'game' THEN
      UPDATE `user` SET ratings_game = ratings_game - 1, ratings_total = ratings_total - 1
      WHERE `user`.id = OLD.user_id;
  END CASE;

  UPDATE `entity`
  SET
    rating_count = rating_count - 1,
    rating_sum = rating_sum - OLD.value,
    rating = (CASE rating_count WHEN 1 THEN 0 ELSE rating_sum - OLD.value / rating_count - 1 END)
  WHERE `entity`.id = var_id;

END//

DELIMITER ;
