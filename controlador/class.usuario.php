<?php
require_once('class.db.php');
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

    function login() {
        $consulta = "SELECT * FROM usuario WHERE usuario = ? AND contrasenia = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $this->usuario, $this->contrasenia);
        $sentencia->execute();
        $cuenta = $sentencia->rowCount();
        if($cuenta > 0) return true;
        else return false;
    }
}

?>