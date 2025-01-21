<?php
require_once('class.db.php');
    class prestamo{

        private $conn;
        private $id_usuario;
        private $id_juego;
        private $id_amisusu;
        private $fecha_prestamo;
        private $devuelto;

        public function __construct(int $id=0, int $iu=0, int $ij=0, int $ia=0, String $fp="", bool $d=false) {
            $this->conn = new db();
            $this->id = $id;
            $this->id_usuario = $iu;
            $this->id_juego = $ij;
            $this->id_amisusu = $ia;
            $this->fecha_prestamo = $fp;
            $this->devuelto = $d;
        }
    }
?>