<?php
include '../config/config.php';


class Model 
{
    protected $db;

    public function __construct()
    {
        global $db_host, $db_name, $db_user, $db_pass;
        try {
            $dsn = "pgsql:host={$db_host};dbname={$db_name}";
            $this->db = new PDO($dsn, $db_user,$db_pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die('Ошибка подключения к БД: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Ошибка: ' . $e->getMessage());
        }
    }

    public function getUsers()
    {
        $stmt = $this->db->query("SELECT login, fio
                                    FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getBooks()
    {
        $stmt = $this->db->query("SELECT id_book, title, author, cover_image, user_id, allow_download
                                    FROM books
                                    ORDER BY id_book ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUsers($login,$fio,$password)
    {

        $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE login = :login");
        $checkStmt->bindParam(':login', $login);
        $checkStmt->execute();
        $userExists = $checkStmt->fetchColumn();


        if ($userExists > 0)
        {

            return ['status' => 'error', 'message' => 'Данный пользователь с таким логином уже существует'];

        } else 
        {
            $hashed_password = hash('sha256', $password);

            $stm = $this->db->prepare("INSERT into users (login, fio, hash_password) 
                                        values (:login,:fio,:hash_password) ");
    
            $stm->bindParam(':login',$login);
            $stm->bindParam(':fio',$fio);
            $stm->bindParam(':hash_password',$hashed_password);
    
            if ($stm->execute()) {

                $stm2 = $this->db->query("SELECT id, login, fio
                                                from users
                                                order by id desc
                                                limit 1");

                // return $stm2->fetchAll(PDO::FETCH_ASSOC);
                
                return ['status' => 'success', 'User' => $stm2->fetch(PDO::FETCH_OBJ)];
            } else {
                return ['status' => 'error', 'message' => 'Ошибка при добавлении пользователя'];
            }

        }
    }

    public function authUsers($login,$password)
    {
       
        $stmt = $this->db->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && hash('sha256', $password) === $user['hash_password']) {
            // Успешная аутентификация
            $_SESSION["user"] = $user;
            
            // Добавляем выборку роли и ФИО пользователя
            $login = $user['login'];
            $fio = $user['fio'];
            $idUser = $user['id'];
            
            // Отправка JSON-ответа с ФИО пользователя
            header('Content-Type: application/json');
            return ['status' => 'success', 'id' => $idUser,'login' => $login, 'full_name' => $fio];
            exit();
        } else {
            // Ошибка авторизации
            header('Content-Type: application/json');
            return ['status' => 'error', 'message' => 'Неверное имя пользователя или пароль.'];
            exit();
        }

    }

}
