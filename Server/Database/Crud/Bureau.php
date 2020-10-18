<?php
    namespace Server\Database\Crud;

    require_once $_SERVER['DOCUMENT_ROOT'] . "/Server/Database/Database.php";

    use Server\Database\Database;

    class Bureau extends Database
    {

        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Получение данных о людях и их компании
         *
         * @var String $bureauInfoQuery - запрос на получение данных о людях и их компании
         * @var String $personsQuery    - запрос на получение id, name человека
         *
         * @return array[]
         */

        public function index()
        {
            $query = "SELECT person.id as person_id, person.surname, person.name, 
                             person.year_of_birth, company.id as company_id, DATE_FORMAT(company.gosreg_date, '%d.%m.%Y') as gosreg_date, 
                             company.opf, company.title
                      FROM company 
                      INNER JOIN person 
                            ON company.person_id = person.id 
                      WHERE person.id IN 
                                (SELECT person.id FROM person) 
                      ORDER BY person_id";

            $bureauInfo = $this->select($query);

            $personsQuery = "SELECT id, name FROM person;";
            $persons = $this->select($personsQuery);

            return [$bureauInfo, $persons];
        }

        /**
         * Создание новой компании человека
         *
         * @var String $addCompany      - запрос на создание новой компании
         */

        public function create()
        {

            $addCompany = $this->db->prepare("INSERT INTO company(opf, title, gosreg_date, person_id) 
                                                                    VALUES(?, ?, ?, ?);");
            $addCompany->execute( array(
                                        $_POST["opf"], $_POST["titleCompany"],
                                        $_POST["gosreg_date"], $_POST["personId"]
                                )
            );
        }

        /**
         * Удаление компании человека
         *
         * @var String $delCompany      - запрос на удаление компании
         */

        public function delete()
        {
            $delCompany = $this->db->prepare("DELETE FROM company WHERE id = ?;");
            $delCompany->execute(array($_POST["companyId"]));
        }

        /**
         * Редактирование информации о человеке и его компании
         *
         * @var String $updateCompany   - запрос на обновление информации о компании
         * @var String $gosregDate      - форматирование даты, введённой пользователем, в приемлимый формат БД
         */

        public function edit()
        {
            $updateCompany = $this->db->prepare("UPDATE company SET gosreg_date = ?, opf = ?, 
                                                                             title = ? 
                                                                WHERE company.id = ?");

            $gosregDate = date_format(date_create($_POST["gosreg_date"]), 'Y-m-d');

            $updateCompany->execute(array($gosregDate, $_POST["opf"], $_POST["title"], $_POST["companyId"]));
        }

        public function __destruct()
        {
            $this->db = null;
        }
    }
?>