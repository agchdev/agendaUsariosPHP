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

    public function compContra($usu, $con){
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasenia = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $usu, $con);
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
                    FROM usuarios
                    WHERE usuario != 'admin'";
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

    public function getUsuarios($buscador = ""){
        $usuario = "";
        if($buscador != ""){
            $consulta = "SELECT *
                    FROM usuarios
                    WHERE usuario LIKE ?";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $buscador = "%" . $buscador . "%";
            $sentencia->bind_param('s', $buscador);
        }else{
            $consulta = "SELECT *
                        FROM usuarios";
            $sentencia = $this->conn->getConn()->prepare($consulta);
        }
        $sentencia->execute();
        $sentencia->bind_result($this->id, $this->usuario, $this->contrasenia);

        $usuarios = array();
        while($sentencia->fetch()){
            $contrasenia = "";
            $cantAsteriscos =strlen($this->contrasenia);
            for ($i=0; $i < $cantAsteriscos; $i++) { 
                $contrasenia.="*";
            }
            $usuarios[] = array(
                "id" => $this->id,
                "usuario" => $this->usuario,
                "contrasenia" => $contrasenia
            );
        }

        return $usuarios;
    }

    public function getUsu($i){
        $consulta = "SELECT *
                    FROM usuarios
                    WHERE id = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("i", $i);
        $sentencia->execute();
        $sentencia->bind_result($this->id, $this->usuario, $this->contrasenia);
        $usuarios = array();
        $sentencia->fetch();
        $usuarios["id"] = $this->id;
        $usuarios["usuario"] = $this->usuario;
        $usuarios["contrasenia"] = $this->contrasenia;

        return $usuarios;
    }

    function modificarUsuario($usu, $con, $i){
        $consulta = "UPDATE usuarios
                    SET usuario = ?, contrasenia = ?
                    WHERE id = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param('ssi', $usu, $con, $i);
        if($sentencia->execute()) return true;
        else return false;
    }
}

?>