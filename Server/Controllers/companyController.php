<?php
    namespace Server;

    require_once "../Database/Crud/Bureau.php";

    use Server\Database\Crud\Bureau;

    $bureau = new Bureau();

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

        $bureau->create();

        header("Location: ".$_SERVER['HTTP_REFERER']);

        /**
         * Удаление компании человека
         * на вход приходит
         *          $_POST['companyId']       - id компании
         */

    } else if ($_POST["action"] === "delete") {

        $bureau->delete();

        header("Location: ".$_SERVER['HTTP_REFERER']);


        /**
         * Редактирование информации о компании
         * Информация на входе $_POST[
         *           companyId      - id company
         *           gosreg_date:   - дата регистрации компании
         *           opf:           - опф компании
         *           title:         - наименование компании
         *           action: "edit" - действие - в данном случае - редактирование
         * ]
         */

    } else if ($_POST["action"] === "edit") {
        $bureau->edit();
    }

?>