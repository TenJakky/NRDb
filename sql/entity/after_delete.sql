DELIMITER //

CREATE TRIGGER `entity_after_delete`
AFTER DELETE ON `entity`
FOR EACH ROW
  BEGIN

    UPDATE `stat_entity`
    SET count = count - 1
    WHERE type = OLD.type;

  END//

DELIMITER ;
