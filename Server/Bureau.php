<?php
    namespace Server;

    class Bureau {

        /**
         * @var $username - логин юзера для доступа к БД
         */
        private $username;

        /**
         * @var $pwd - пароль юзера для доступа к БД
         */
        private $pwd;

        /**
         * @var $db - соединение с БД
         */
        private $db;

        public function __construct()
        {

            $info_db = parse_ini_file(realpath($_SERVER['DOCUMENT_ROOT'] . "/configs/database.ini"));

            $user   = $info_db["db_user"];
            $pwd    = $info_db["db_password"];

            $connection = "mysql:host=" . $info_db["db_host"] .";dbname=" . $info_db["db_name"];

            $this->db = new \PDO($connection, $user, $pwd, array(
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ));
        }

        /**
         * Получение данных о людях и их компании
         *
         * @var String $bureauInfoQuery - запрос на получение данных о людях и их компании
         * @var String $personsQuery    - запрос на получение id, name person
         *
         * @return array[]
         */

        public function index()
        {
            $bureauInfoQuery = "SELECT person.id, person.surname, person.name, 
                                              person.year_of_birth, 
                                              DATE_FORMAT(company.gosreg_date, '%d.%m.%Y') as gosreg_date,
                                              company.opf, company.title 
                                       FROM company
                                       INNER JOIN person
                                        ON person.company_id = company.id";

            $bureauInfo = $this->select($bureauInfoQuery);

            $personsQuery = "SELECT id, name FROM person WHERE company_id IS NULL;";
            $persons = $this->select($personsQuery);

            return [$bureauInfo, $persons];
        }

        /**
         * Создание новой компании человека
         *
         * @var String $addCompany      - запрос на создание новой компании
         * @var String $getLastCompany  - запрос на получение последней записи о компании
         *                                для получения id только что созданной компании
         * @var String $updUserComp    -  запрос обновления company_id человека для присваивания
         *                                ему id компании
         */

        public function create()
        {
            $addCompany = "INSERT INTO company(opf, title, gosreg_date ) VALUES('" . $_POST["opf"] .  "', 
                                             '".  $_POST["titleCompany"] ."',
                                             '" . $_POST["gosreg_date"] .  "');";
            $this->db->query($addCompany);

            $getLastCompany = "SELECT id FROM company WHERE title = '" . $_POST["titleCompany"]
                . "' && opf =  '". $_POST["opf"] . "';";

            $idLastCompany = $this->select($getLastCompany)[0]["id"];

            $updUserComp = "UPDATE person set company_id = '". $idLastCompany ."' 
                                        WHERE id = '" . $_POST["personId"] . "';";

            $this->db->query($updUserComp);

//            header("Location:../index.php");
        }

        /**
         * Удаление компании человека
         *
         * @var int $companyId          - id компании
         * @var String $delCompany      - запрос на удаление компании
         * @var String $delCompPerson   - отбираем компанию у человека, путём
         *                                присвоения NULL company_id
         *
         */

        public function delete()
        {
            $companyId = $this->getCompanyId($_POST["personId"]);

            $delCompany = "DELETE FROM company WHERE company.id = '" . $companyId . "'";
            $delete = $this->db->query($delCompany);

            $delCompPerson = "UPDATE person set company_id = NULL 
                                            WHERE id = '" . $_POST["personId"] . "';";
            $this->db->query($delCompPerson);

//            header("Location:../index.php");
        }

        /**
         * Редактирование информации о человеке и его компании
         *
         * @var String $updatePerson    - запрос на обновление информации о человеке
         * @var int $companyId          - id компании
         * @var String $gosregDate      - форматирование даты, введённой пользователем, в приемлимый формат БД
         * @var String $updateCompany   - запрос на обновление информации о компании
         *
         */

        public function edit()
        {
            $updatePerson = "UPDATE person SET surname = '" . $_POST["surname"] . "', 
                                           name = '" . $_POST["name"] .  "', 
                                           year_of_birth = '" . $_POST["year_of_birth"] . "'
                                       WHERE id = '" . $_POST["personId"] ."';";
            $this->db->query($updatePerson);

            $companyId = $this->getCompanyId($_POST["personId"]);

            $gosregDate = date_format(date_create($_POST["gosreg_date"]), 'Y-m-d');

            $updateCompany = "UPDATE company SET gosreg_date = '" . $gosregDate ."',
                                           opf = '". $_POST["opf"] . "' ,
                                           title = '". $_POST["title"] . "'
                                        WHERE company.id = '". $companyId . "';";

            $this->db->query($updateCompany);

//            header("Location:../index.php");
        }

        /**
         * Вспомогательный метод обработки select запросов
         * для упрощённой работы с полученными данными
         *
         * @param $query
         * @return array
         */

        public function select($query)
        {
            $bureauInfo = [];

            foreach($this->db->query($query) as $keyFirst => $row) {
                foreach ($row as $keySecond => $col) {
                    $bureauInfo[$keyFirst][$keySecond] = $col;
                }
            }

            return $bureauInfo;
        }

        /**
         * Вспомогательный метод получения id компании
         *
         * @param $personId
         * @return mixed
         */

        private function getCompanyId($personId)
        {
            $query = "SELECT company_id FROM person WHERE person.id = '". $_POST["personId"] . "'";
            $companyId = $this->select($query)[0]["company_id"];

            return $companyId;
        }

        public function __destruct()
        {
            $this->bd = null;
        }
    }
?>