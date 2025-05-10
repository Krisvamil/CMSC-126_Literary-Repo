-- migrations/008_seed.up.sql

START TRANSACTION;
INSERT INTO `users` (username, email, password_hash, role)
VALUES
  ('admin', 'admin@example.com',
   -- use PHP's password_hash('password', PASSWORD_BCRYPT')
   '$2y$10$examplehashforpasswordabcd1234', 'author')
ON DUPLICATE KEY UPDATE email = email;
COMMIT;
