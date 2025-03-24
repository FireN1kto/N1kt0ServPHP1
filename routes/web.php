<?php

use Src\Route;

Route::add('go', [Controller\Site::class, 'index']);
Route::add('help',[Controller\Site::class, 'hello']);
