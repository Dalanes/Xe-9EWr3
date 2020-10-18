<?php
    namespace Server\Database;

    class Database
    {
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
        protected $db;

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

            return $this->db;
        }

        /**
         * Вспомогательный метод обработки select запросов
         * для упрощённой работы с полученными данными
         *
         * @param $query
         * @return array
         */

        protected function select($query)
        {
            $bureauInfo = [];

            foreach($this->db->query($query) as $keyFirst => $row) {
                foreach ($row as $keySecond => $col) {
                    $bureauInfo[$keyFirst][$keySecond] = $col;
                }
            }

            return $bureauInfo;
        }
    }

?>