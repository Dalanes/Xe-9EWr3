<?php

    namespace Server;

    require_once "../Database/Crud/Persons.php";

    use Server\Database\Crud\Persons;

    $person = new Persons();

    /**
     * Регистрация нового пользователя
     * Информация на входе $_POST[
     *      "name"          - имя человека
     *      "surname"       - его фамилия
     *      "year_of_birth" - и дата рождения
     *
     *      "action"        - create - действие, которое необходимо выполнить (создать пользователя)
     * ]
     */

    if ($_POST["action"] === "create") {

        $person->create();

        header("Location: ".$_SERVER['HTTP_REFERER']);

        /**
         * Удаление пользователя
         * на вход приходит
         *          $_POST['personId']       - id person
         */

    } else if ($_POST["action"] === "delete") {

        $person->delete();

        header("Location: ".$_SERVER['HTTP_REFERER']);

        /**
         * Редактирование информации о пользователе
         * Информация на входе $_POST[
         *           surname        - фамилия человека
         *           name:          - его имя
         *           year_of_birth: - дата рождения
         *           action: "edit" - действие - в данном случае - редактирование
         * ]
         */

    } else if ($_POST["action"] === "edit") {
        $person->edit();
    }

?>