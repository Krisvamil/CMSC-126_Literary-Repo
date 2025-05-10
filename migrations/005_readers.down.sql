-- migrations/005_readers.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `readers`;
COMMIT;
