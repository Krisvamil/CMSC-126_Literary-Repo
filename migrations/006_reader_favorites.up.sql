-- migrations/006_reader_favorites.up.sql

START TRANSACTION;
CREATE TABLE IF NOT EXISTS `reader_favorites` (
  `reader_id` INT UNSIGNED NOT NULL,
  `work_id`   INT UNSIGNED NOT NULL,
  PRIMARY KEY (`reader_id`, `work_id`),
  FOREIGN KEY (`reader_id`) REFERENCES `readers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`work_id`)   REFERENCES `works`(`id`)   ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;
