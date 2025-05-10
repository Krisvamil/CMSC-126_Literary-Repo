-- migrations/003_comments.up.sql

START TRANSACTION;
CREATE TABLE IF NOT EXISTS `comments` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `work_id`    INT UNSIGNED NOT NULL,
  `user_id`    INT UNSIGNED NOT NULL,
  `body`       TEXT          NOT NULL,
  `created_at` TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`work_id`) REFERENCES `works`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;
