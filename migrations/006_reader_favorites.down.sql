-- migrations/006_reader_favorites.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `reader_favorites`;
COMMIT;
