DELIMITER //

CREATE TRIGGER `entity_after_insert`
AFTER INSERT ON `entity`
FOR EACH ROW
  BEGIN

    UPDATE `entity_statistic`
    SET rating_count = rating_count + 1
    WHERE type = NEW.type;

  END//



CREATE TRIGGER `entity_after_delete`
AFTER DELETE ON `entity`
FOR EACH ROW
  BEGIN

    UPDATE `entity_statistic`
    SET rating_count = rating_count - 1
    WHERE type = OLD.type;

  END//

DELIMITER ;
