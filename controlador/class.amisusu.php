<?php

class amiUsus{
    private $conn;
    private $id;
    private $id_usuario;
    private $nombre;
    private $fecha_nac;

    public function __construct(int $id=0, int $iu=0, String $n="", String $fn="") {
        $this->conn = new db();
        $this->id = $id;
        $this->id_usuario = $iu;
        $this->nombre = $n;
        $this->fecha_nac = $fn;
    }
}

?>