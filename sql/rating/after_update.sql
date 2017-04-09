DELIMITER //

CREATE TRIGGER `rating_after_update`
AFTER UPDATE ON `rating`
FOR EACH ROW
  BEGIN

    UPDATE `entity`
    SET
      rating_sum = rating_sum - OLD.value + NEW.value,
      rating = (rating_sum / rating_count)
    WHERE id = NEW.entity_id;

  END//

DELIMITER ;
