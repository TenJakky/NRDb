# after update

CREATE TRIGGER `rating_movie_after_insert`
AFTER INSERT ON `rating_movie`
FOR EACH ROW
  UPDATE `user` SET ratings_movie = ratings_movie + 1
  WHERE rating_movie.id = NEW.user_id;

CREATE TRIGGER `rating_series_after_insert`
AFTER INSERT ON `rating_series`
FOR EACH ROW
  UPDATE `user` SET ratings_series = ratings_series + 1
  WHERE rating_series.id = NEW.user_id;

CREATE TRIGGER `rating_season_after_insert`
AFTER INSERT ON `rating_season`
FOR EACH ROW
  UPDATE `user` SET ratings_season = ratings_season + 1
  WHERE rating_season.id = NEW.user_id;

CREATE TRIGGER `rating_book_after_insert`
AFTER INSERT ON `rating_book`
FOR EACH ROW
  UPDATE `user` SET ratings_book = ratings_book + 1
  WHERE rating_book.id = NEW.user_id;

CREATE TRIGGER `rating_music_after_insert`
AFTER INSERT ON `rating_music`
FOR EACH ROW
  UPDATE `user` SET ratings_music = ratings_music + 1
  WHERE rating_music.id = NEW.user_id;

CREATE TRIGGER `rating_game_after_insert`
AFTER INSERT ON `rating_game`
FOR EACH ROW
  UPDATE `user` SET ratings_game = ratings_game + 1
  WHERE rating_game.id = NEW.user_id;

# after delete

CREATE TRIGGER `rating_movie_after_delete`
AFTER DELETE ON `rating_movie`
FOR EACH ROW
  UPDATE `user` SET ratings_movie = ratings_movie - 1
  WHERE rating_movie.id = OLD.user_id;

CREATE TRIGGER `rating_series_after_delete`
AFTER DELETE ON `rating_series`
FOR EACH ROW
  UPDATE `user` SET ratings_series = ratings_series - 1
  WHERE rating_series.id = OLD.user_id;

CREATE TRIGGER `rating_season_after_delete`
AFTER DELETE ON `rating_season`
FOR EACH ROW
  UPDATE `user` SET ratings_season = ratings_season - 1
  WHERE rating_season.id = OLD.user_id;

CREATE TRIGGER `rating_book_after_delete`
AFTER DELETE ON `rating_book`
FOR EACH ROW
  UPDATE `user` SET ratings_book = ratings_book - 1
  WHERE rating_book.id = OLD.user_id;

CREATE TRIGGER `rating_music_after_delete`
AFTER DELETE ON `rating_music`
FOR EACH ROW
  UPDATE `user` SET ratings_music = ratings_music - 1
  WHERE rating_music.id = OLD.user_id;

CREATE TRIGGER `rating_game_after_delete`
AFTER DELETE ON `rating_game`
FOR EACH ROW
  UPDATE `user` SET ratings_game = ratings_game - 1
  WHERE rating_game.id = OLD.user_id;
