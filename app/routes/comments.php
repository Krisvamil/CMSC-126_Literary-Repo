<?php
use App\Controllers\CommentController;

return [
    // Add a comment to a work
    'POST /comments/store'   => [CommentController::class, 'store'],
    // Delete a comment
    'POST /comments/delete'  => [CommentController::class, 'destroy'],
];
