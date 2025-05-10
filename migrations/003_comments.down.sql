-- migrations/003_comments.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `comments`;
COMMIT;
