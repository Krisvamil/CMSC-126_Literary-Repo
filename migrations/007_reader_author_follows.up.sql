-- migrations/007_reader_author_follows.up.sql

START TRANSACTION;
CREATE TABLE IF NOT EXISTS `reader_author_follows` (
  `reader_id` INT UNSIGNED NOT NULL,
  `author_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`reader_id`, `author_id`),
  FOREIGN KEY (`reader_id`) REFERENCES `readers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`author_id`) REFERENCES `authors`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;
