-- migrations/008_seed.down.sql

START TRANSACTION;
DELETE FROM `users` WHERE username = 'admin';
COMMIT;
