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

        public function getPrestamo($usuario, $buscador=""){
            if ($buscador != "") {
                $consulta = "SELECT prestamos.id, usuarios.id , amisusuarios.nombre, juegos.juego, juegos.urlFoto, prestamos.fecha_inicio, prestamos.devuelta
                             FROM amisusuarios, juegos, prestamos 
                             WHERE prestamos.id_usuario = usuarios.id AND prestamos.id_ami = amisusuarios.id AND usuarios.usuario = ? AND 
                             (amisusuarios.nombre LIKE ? OR amisusuarios.apellido LIKE ?)";
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('sss', $usuario, $buscador, $buscador);
            } else {
                $consulta = "SELECT amisusuarios.id, id_usuario, amisusuarios.nombre, amisusuarios.apellido, amisusuarios.fecha_nac 
                             FROM amisusuarios, usuarios 
                             WHERE id_usuario = usuarios.id AND usuarios.usuario = ?";
                $sentencia = $this->conn->getConn()->prepare($consulta);
                $sentencia->bind_param('s', $usuario);
            }
        
            $sentencia->execute();
            $sentencia->bind_result($this->id, $this->id_usuario, $this->nombre, $this->apellidos, $this->fecha_nac);
        
            $amigosUsu = array();
            while ($sentencia->fetch()) {
                $amigosUsu[] = array(
                    "id" => $this->id,
                    "id_usuario" => $this->id_usuario,
                    "nombre" => $this->nombre,
                    "apellidos" => $this->apellidos,
                    "fecha_nac" => $this->fecha_nac
                );
            }
            $sentencia->close();
            return $amigosUsu;
        }
    }
?>