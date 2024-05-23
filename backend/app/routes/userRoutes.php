<?php


include '../controller/userController.php';


$controller = new UserController();

// Определяем маршруты
Route::get('/users', 'UserController', 'getUsers');
Route::post('/add-user', 'UserController', 'addUsers');
Route::post('/auth-user', 'UserController', 'authUsers');
Route::get('/books', 'UserController', 'getBooks');

// Выполняем маршрутизацию
Route::dispatch();