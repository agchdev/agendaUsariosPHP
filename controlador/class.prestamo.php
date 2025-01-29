<?php
require_once('class.db.php');
    class prestamo{

        private $conn;
        private $id;
        private $id_usuario;
        private $id_juego;
        private $id_amisusu;
        private $fecha_prestamo;
        private $devuelto;

        public function __construct(int $i=0, int $iu=0, int $ij=0, int $ia=0, String $fp="", bool $d=false) {
            $this->conn = new db();
            $this->id = $i;
            $this->id_usuario = $iu;
            $this->id_juego = $ij;
            $this->id_amisusu = $ia;
            $this->fecha_prestamo = $fp;
            $this->devuelto = $d;
        }

        public function insertarPrestamo($idUsu, $idAmi, $idJuego, $fechaPrestamo){
            $consulta = "INSERT INTO prestamos (id_usuario, id_juego, id_ami, fecha_inicio) VALUES (?, ?, ?, ?)";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('iiis', $idUsu, $idJuego, $idAmi, $fechaPrestamo);
            if($sentencia->execute()) return true;
            else return false;
        }

        public function getPrestamo($usuario, $buscador=""){
            $nombreAmigo="";
            $nombreJuego ="";
            $urlFoto = "";
            if ($buscador != "") {
                $consulta = "SELECT prestamos.id, usuarios.id , amisusuarios.nombre, juegos.juego, juegos.urlFoto, prestamos.fecha_inicio, prestamos.devuelta
                             FROM amisusuarios, juegos, prestamos, usuarios
                             WHERE prestamos.id_usuario = usuarios.id AND prestamos.id_ami = amisusuarios.id AND prestamos.id_juego = juegos.id AND usuarios.usuario = ? AND 
                             (amisusuarios.nombre LIKE ? OR juegos.juego LIKE ?)";
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('sss', $usuario, $buscador, $buscador);
            } else {
                $consulta = "SELECT prestamos.id, prestamos.id_usuario, prestamos.id_ami, amisusuarios.nombre, juegos.juego, juegos.urlFoto, prestamos.fecha_inicio, prestamos.devuelta
                             FROM amisusuarios, juegos, prestamos, usuarios
                             WHERE prestamos.id_usuario = usuarios.id AND prestamos.id_ami = amisusuarios.id AND prestamos.id_juego = juegos.id AND usuarios.usuario = ?";
                $sentencia = $this->conn->getConn()->prepare($consulta);
                $sentencia->bind_param('s', $usuario);
            }
        
            $sentencia->execute();
            $sentencia->bind_result($this->id, $this->id_usuario, $this->id_amisusu, $nombreAmigo, $nombreJuego, $urlFoto, $this->fecha_prestamo, $this->devuelto);
        
            $prestamos = array();
            while ($sentencia->fetch()) {
                $prestamos[] = array(
                    "id" => $this->id,
                    "id_usuario" => $this->id_usuario,
                    "id_amigo" => $this->id_amisusu,
                    "nombreAmigo" => $nombreAmigo,
                    "nombreJuego" => $nombreJuego,
                    "urlFoto" => $urlFoto,
                    "fecha_prestamo" => $this->fecha_prestamo,
                    "devuelto" => $this->devuelto,
                );
            }
            $sentencia->close();
            return $prestamos;
        }

        public function modificarPrestamo($id){
            $consulta = "UPDATE prestamos SET devuelta = 1 WHERE id = ?";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param("i", $id);
            if($sentencia->execute()) return true;
            else return false;
        }
    }
?>