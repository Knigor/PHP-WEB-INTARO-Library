<?php


include '../controller/userController.php';


$controller = new UserController();

// Определяем маршруты
Route::get('/users', 'UserController', 'getUsers');
Route::get('/books', 'UserController', 'getBooks');
Route::post('/add-user', 'UserController', 'addUsers');
Route::post('/auth-user', 'UserController', 'authUsers');
Route::post('/add-book', 'UserController', 'addBooks');
Route::post('/downloadBook', 'UserController', 'downloadBook');
Route::post('/deleteBook', 'UserController', 'deleteBook');
Route::post('/editBook', 'UserController', 'editBook');


// Выполняем маршрутизацию
Route::dispatch();