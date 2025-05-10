-- migrations/007_reader_author_follows.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `reader_author_follows`;
COMMIT;
