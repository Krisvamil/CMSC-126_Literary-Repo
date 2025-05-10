## CMSC 126_Literary-Repo

A lightweight, framework-free PHP literary repository for authors and readers to publish, browse, and comment on works. It uses PSR-4 autoloading, simple routing, MVC-style models/controllers/views, transactional migrations, file-based caching/logging, and an in-memory SQLite test suite.

---

## Requirements

- PHP ≥ 7.4 with `mysqli` and `pdo_sqlite` extensions  
- MySQL ≥ 5.7 (production)  
- Composer (dependency management & autoloading)  
- A web server pointing to the `public/` folder  

---

## Installation

1. **Clone the repo**  
   ```bash
   git clone https://github.com/Krisvamil/CMSC 126_Literary-Repo.git
   cd CMSC 126_Literary-Repo

2. **Install Dependencies**
    ```bash
    composer install

3. **Environment**
    ```bash
    cp .env.example .env
    # Edit .env with your DB credentials, BASE_URL, etc.

4. **Run Migrations**
    ```bash
    composer migrate

## Configuration

All config lives in .env (loaded by vlucas/phpdotenv) and config/config.php:

    DB_HOST=127.0.0.1
    DB_NAME=literary_repo
    DB_USER=db_user
    DB_PASS=db_pass
    DB_CHARSET=utf8mb4

    APP_ENV=local
    APP_DEBUG=true
    BASE_URL=http://localhost

    CACHE_TTL=3600
    SESSION_LIFETIME=1440
    
- config/config.php defines directory constants, loads .env, sets error logging, sessions, and URL helpers.

- config/db.php initializes a singleton mysqli (UTF-8) and exposes get_db().

## Database Migrations

Under migrations/ you have paired up/down SQL scripts plus:

- migrate.php: applies pending .up.sql in a transaction, recording them in a migrations table.
    ```bash
    composer migrate   # php migrations/migrate.php

- rollback.php: rolls back the last batch via matching .down.sql files.
    ```bash
    composer rollback  # php migrations/rollback.php

## Running the App

Serve the public/ folder:
    ```bash
    php -S localhost:8000 -t public

Then browse to http://localhost:8000.

## Directory Structure

literary-repo/
├── app/
│   ├── controllers/      # BaseController, Auth, Work, Comment, Author, Reader
│   ├── models/           # Model base, User, Work, Comment, Author, Reader
│   ├── routes/           # auth.php, works.php, comments.php, authors.php, readers.php
│   └── utils/            # FileCache.php, Logger.php
│   └── views/            # layout.php, login.php, dashboard.php, authors/, readers/, partials/, errors/
├── config/
│   ├── config.php
│   └── db.php
├── migrations/           # NNN_*.up.sql, NNN_*.down.sql, migrate.php, rollback.php, README.md
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── uploads/
│   ├── .htaccess
│   └── index.php
├── storage/
│   ├── cache/
│   ├── logs/             # app.log
│   └── sessions/
├── tests/
│   ├── bootstrap.php
│   ├── phpunit.xml
│   ├── models/           # UserTest.php, WorkTest.php, etc.
│   ├── controllers/      # AuthControllerTest.php, etc.
│   └── views/            # DashboardViewTest.php, etc.
├── vendor/               # Composer dependencies & autoload
├── .env.example
├── .gitignore
├── composer.json
└── README.md             # <- This file

## Storage Utilities

- FileCache (app/utils/FileCache.php)
Simple file-based caching in storage/cache/

- Logger (app/utils/Logger.php)
Timestamped logs in storage/logs/app.log

 ## Testing

 Tests use PHPUnit and in-memory SQLite:
    ```bash
    composer test   # runs phpunit --configuration tests/phpunit.xml

- Models use Model::setTestConnection($pdo)

- Controllers tested without MySQLi

- Views tested via output buffering

Thank you for using CMSC 126_Literary-Repo! Feel free to open issues or PRs on GitHub.
