<?php
use App\Controllers\ReaderController;

return [
    // Reader dashboard (favorites & follows)
    'GET  /readers'          => [ReaderController::class, 'dashboard'],
    // Toggle favorite via AJAX
    'POST /readers/favorite' => [ReaderController::class, 'favorite'],
    // Toggle follow via AJAX
    'POST /readers/follow'   => [ReaderController::class, 'follow'],
];
