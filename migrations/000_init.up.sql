-- migrations/000_init.up.sql

-- Create database if not exists and switch to it
CREATE DATABASE IF NOT EXISTS `literary_repo`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `literary_repo`;

-- Migration history table
CREATE TABLE IF NOT EXISTS `migrations` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `migration`  VARCHAR(255) NOT NULL UNIQUE,
  `batch`      INT NOT NULL,
  `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
