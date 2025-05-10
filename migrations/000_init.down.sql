-- migrations/000_init.down.sql

START TRANSACTION;
DROP TABLE IF EXISTS `migrations`;
DROP DATABASE IF EXISTS `literary_repo`;
COMMIT;
