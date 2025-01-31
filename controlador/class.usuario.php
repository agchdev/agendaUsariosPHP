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

    public function login() {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasenia = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $this->usuario, $this->contrasenia);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        if($resultado->num_rows > 0) return true;
        else return false;
    }

    public function getIdUsu(){
        $consulta = "SELECT id FROM usuarios WHERE usuario = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("s", $this->usuario);
        $sentencia->execute();
        $sentencia->bind_result($this->id);
        $sentencia->fetch();
        return $this->id;
    }
    public function getIdUsuarios(){
        $consulta = "SELECT id, usuario 
                    FROM usuarios";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->execute();
        $sentencia->bind_result($this->id, $this->usuario);
        $ids = array();
        while($sentencia->fetch()){
            $ids[] = array(
                "id" => $this->id,
                "usuario" => $this->usuario
            );
        }
        return $ids;
        
    }
    public function registrarUsuario(){
        $consulta = "INSERT INTO usuarios (usuario, contrasenia) VALUES (?,?);";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $this->usuario, $this->contrasenia);
        if($sentencia->execute()) return true;
        else return false;
    }
}

?>