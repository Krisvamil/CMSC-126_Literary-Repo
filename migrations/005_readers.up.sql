-- migrations/005_readers.up.sql

START TRANSACTION;
CREATE TABLE IF NOT EXISTS `readers` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id`     INT UNSIGNED NOT NULL UNIQUE,
  `preferences` JSON,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;
