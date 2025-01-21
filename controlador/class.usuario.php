<?php
require_once('class.db.php');
class usuario{
    private $conn;
    private $id;
    private $usuario;
    private $contrasenia;

    public function __construct(int $id=0, String $u="", String $c="") {
        $this->conn = new db();
        $this->id = $id;
        $this->usuario = $u;
        $this->contrasenia = $c;
    }

    function login() {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasenia = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $this->usuario, $this->contrasenia);
        $sentencia->execute();
        $sentencia->get_result();
        $cuenta = $sentencia->num_rows();
        if($cuenta > 0) return true;
        else return false;
    }
}

?>