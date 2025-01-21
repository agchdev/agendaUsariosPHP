<?php
    class db{
        private $conn;

        public function __construct(){
            require_once('../../cred.php');
            $this->conn = new mysqli("Localhost", USU_CONN, PSW_CONN, "colegio");
        }

        // Método para obtener la conexión mysqli
        public function getConn() {
            return $this->conn;
        }
    }

?>