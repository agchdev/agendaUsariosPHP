<?php
    class juego{
        private $conn;
        private $usuario;
        private $contrasenia;

        public function __construct(int $id=0, String $u="", String $c="") {
            $this->conn = new db(); 
            $this->id = $id;
            $this->usuario = $u;
            $this->contrasenia = $c;
        }
    }
?>