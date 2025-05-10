<?php
declare(strict_types=1);

// 1) Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2) Make sure sessions and BASE_URL exist for view rendering
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

// 3) In-memory SQLite setup for model tests
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 4) Create the minimal schema your models require
$pdo->exec("
    CREATE TABLE users (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      username TEXT UNIQUE,
      email TEXT UNIQUE,
      password_hash TEXT,
      role TEXT,
      created_at TEXT,
      updated_at TEXT
    );
    CREATE TABLE works (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      author_id INTEGER,
      title TEXT,
      body TEXT,
      created_at TEXT,
      updated_at TEXT
    );
    CREATE TABLE comments (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      work_id INTEGER,
      user_id INTEGER,
      body TEXT,
      created_at TEXT
    );
    CREATE TABLE authors (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      user_id INTEGER UNIQUE,
      bio TEXT
    );
    CREATE TABLE readers (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      user_id INTEGER UNIQUE,
      preferences TEXT
    );
    CREATE TABLE reader_favorites (
      reader_id INTEGER,
      work_id INTEGER
    );
    CREATE TABLE reader_author_follows (
      reader_id INTEGER,
      author_id INTEGER
    );
");

// 5) Inject the PDO into Model for test mode
\App\Models\Model::setTestConnection($pdo);
