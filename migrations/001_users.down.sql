-- migrations/001_users.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `users`;
COMMIT;
