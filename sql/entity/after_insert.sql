DELIMITER //

CREATE TRIGGER `entity_after_insert`
AFTER INSERT ON `entity`
FOR EACH ROW
  BEGIN

    UPDATE `stat_entity`
    SET rating_count = rating_count + 1
    WHERE type = NEW.type;

  END//

DELIMITER ;
