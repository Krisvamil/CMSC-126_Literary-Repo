CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT,
  email TEXT,
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

/* plus any other tables your models reference, e.g.:
CREATE TABLE authors (...);
CREATE TABLE readers (...);
CREATE TABLE reader_favorites (...);
CREATE TABLE reader_author_follows (...);
*/
