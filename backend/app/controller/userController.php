<?php

include  '../model/model.php';


class UserController
{
    private $model;


    public function __construct()
    {
        $this->model = new Model();
    }


    public function getUsers()
    {
        
        $users = $this->model->getUsers();

        echo json_encode($users);
        
    }

    public function getBooks()
    {
        $books = $this->model->getBooks();

        echo json_encode($books);
    }

    public function addUsers()
    {
        $login = $_POST['login'] ?? null;
        $fio = $_POST['fio'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($login && $fio && $password){

            $success = $this->model->addUsers($login,$fio,$password);

            echo json_encode($success);

        }  else {
            echo json_encode(['status' => 'error', 'message' => 'Данные пусты']);

        }
    }
    
    public function authUsers()
    {
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($login && $password){
            $success = $this->model->authUsers($login,$password);


            echo json_encode($success);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Данные пусты']);
        }
    }
}