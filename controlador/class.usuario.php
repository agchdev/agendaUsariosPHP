<?php

class usuario{
    private $conn;
    private $id;
    private $usuario;
    private $contraseña;

    public function __construct(int $id=0, String $u="", String $c="") {
        $this->conn = new db();
        $this->id = $id;
        $this->usuario = $u;
        $this->contraseña = $c;
    }
}

?>