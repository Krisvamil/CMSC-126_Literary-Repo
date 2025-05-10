-- migrations/004_authors.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `authors`;
COMMIT;
