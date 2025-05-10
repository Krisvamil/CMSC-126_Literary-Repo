<?php
use App\Controllers\AuthorController;

return [
    // Author dashboard (lists own works)
    'GET  /authors'          => [AuthorController::class, 'dashboard'],
];
