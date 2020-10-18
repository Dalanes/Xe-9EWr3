<?php
    namespace Server;

    require_once "Bureau.php";

    $db = new Bureau();

    /**
     * Создание новой компании человека
     * Информация на входе $_POST[
     *  "gosreg_date"   - дата регистрации компании
     *  "personId"      - id человека
     *  "opf"           - её ОПФ
     *  "titleCompany"         - нименование компании
     * ]
     */

    if ($_POST["action"] === "create") {

        $db->create();

        header("Location:../");

        /**
         * Удаление компании человека
         * на вход приходит
         *          $_POST['companyId']       - id person
         */

    } else if ($_POST["action"] === "delete") {

        $db->delete();

        header("Location:../");

        /**
         * Редактирование информации о пользователе и его компании
         * Информация на входе $_POST[
         *           companyId      - id company
         *           surname        - фамилия человека
         *           name:          - его имя
         *           year_of_birth: - дата рождения
         *           gosreg_date:   - дата регистрации компании
         *           opf:           - опф компании
         *           title:         - наименование компании
         *           action: "edit" - действие - в данном случае - редактирование
         * ]
         */

    } else if ($_POST["action"] === "edit") {
        $db->edit();
    }

?>