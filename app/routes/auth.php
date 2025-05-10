<?php
use App\Controllers\AuthController;
return [
  'GET  /auth/login'  => [AuthController::class,'showLoginForm'],
  'POST /auth/login'  => [AuthController::class,'login'],
  'GET  /auth/logout' => [AuthController::class,'logout'],
];
