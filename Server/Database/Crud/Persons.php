<?php

    namespace Server\Database\Crud;

    require_once $_SERVER['DOCUMENT_ROOT'] . "/Server/Database/Database.php";

    use Server\Database\Database;

    class Persons extends Database
    {

        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Получение данных о пользователях
         *
         * @return array $persons [
         *      id,
         *      name,           - имя человека
         *      surname,        - его фамилия
         *      year_of_birth   - и день рождения
         * ]
         *
         */

        public function index()
        {
            $query = "SELECT * FROM person;";

            $persons = $this->select($query);

            return $persons;
        }

        /**
         * Регистрация нового пользователя
         *
         * @var String $addPerson      - запрос на создание нового пользователя
         *
         */

        public function create()
        {

            $addPerson = $this->db->prepare("INSERT INTO person(name, surname, year_of_birth) 
                                                                        VALUES(?, ?, ?);");

            $addPerson->execute( array($_POST["name"], $_POST["surname"], $_POST["year_of_birth"]) );
        }

        /**
         * Удаление пользователя
         *
         * @var String $delPerson      - запрос на удаление пользователя
         */

        public function delete()
        {
            $delCompany = $this->db->prepare("DELETE FROM person WHERE id = ?;");
            $delCompany->execute(array($_POST['personId']));
        }

        /**
         * Редактирование информации о пользователе
         *
         * @var String $updatePerson   - запрос на обновление информации о пользователе
         */

        public function edit()
        {

            $updatePerson = $this->db->prepare("UPDATE person SET name = ?, surname = ?, 
                                                                                 year_of_birth = ? 
                                                                    WHERE person.id = ?");

            $updatePerson->execute(array($_POST["name"], $_POST["surname"],
                                        $_POST["year_of_birth"], $_POST["personId"]));
        }

        public function __destruct()
        {
            $this->db = null;
        }
    }
?>