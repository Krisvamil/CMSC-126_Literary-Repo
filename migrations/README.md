# Database Migrations

This folder contains all SQL migration scripts and a simple runner to build, update, and rollback your database schema in a controlled, transactional way.

## Folder Structure

migrations/
├── 000_init.up.sql
├── 000_init.down.sql
├── 001_users.up.sql
├── 001_users.down.sql
├── 002_works.up.sql
├── 002_works.down.sql
├── 003_comments.up.sql
├── 003_comments.down.sql
├── 004_authors.up.sql
├── 004_authors.down.sql
├── 005_readers.up.sql
├── 005_readers.down.sql
├── 006_reader_favorites.up.sql
├── 006_reader_favorites.down.sql
├── 007_reader_author_follows.up.sql
├── 007_reader_author_follows.down.sql
├── 008_seed.up.sql
├── 008_seed.down.sql
├── migrate.php
├── rollback.php
└── README.md


- **`*.up.sql`** — Applies schema changes (CREATE/ALTER).  
- **`*.down.sql`** — Reverts those changes (DROP).  
- **`migrate.php`** — Runs all pending `*.up.sql` in batch order.  
- **`rollback.php`** — Rolls back the most recent batch by running matching `*.down.sql`.

---

## Prerequisites

- PHP 7.4+ with CLI support  
- MySQL 5.7+ (InnoDB)  
- A configured **`config/db.php`** that connects to your database  
- Writable **`storage/logs/app.log`** for error logging  

---

## Usage

### Applying New Migrations

From your project root:

```bash
php migrations/migrate.php
