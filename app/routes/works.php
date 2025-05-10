<?php
// e.g. app/routes/works.php
use App\Controllers\WorkController;
return [
  'GET  /works'        => [WorkController::class,'index'],
  'GET  /works/create' => [WorkController::class,'create'],
  'POST /works/store'  => [WorkController::class,'store'],
  'GET  /works/edit'   => [WorkController::class,'edit'],
  'POST /works/update' => [WorkController::class,'update'],
  'POST /works/delete' => [WorkController::class,'destroy'],
];
