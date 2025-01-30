<?php
    require_once('class.db.php');
    class amiUsus{
        private $conn;
        private $id;
        private $id_usuario;
        private $nombre;
        private $apellidos;
        private $fecha_nac;

        public function __construct(int $id=0, int $iu=0, String $n="", String $ap="", String $fn="") {
            $this->conn = new db();
            $this->id = $id;
            $this->id_usuario = $iu;
            $this->nombre = $n;
            $this->apellidos = $ap;
            $this->fecha_nac = $fn;
        }

        public function getAmigos($usuario, $buscador = "") {
            if ($buscador != "") {
                $consulta = "SELECT amisusuarios.id, id_usuario, amisusuarios.nombre, amisusuarios.apellido, amisusuarios.fecha_nac 
                             FROM amisusuarios, usuarios 
                             WHERE id_usuario = usuarios.id AND usuarios.usuario = ? AND 
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

        public function getAmigosAdmin($buscador = "") {
            $usuario = "";
            if ($buscador != "") {
                $consulta = "SELECT usuarios.usuario, amisusuarios.id, id_usuario, amisusuarios.nombre, amisusuarios.apellido, amisusuarios.fecha_nac 
                             FROM amisusuarios, usuarios 
                             WHERE id_usuario = usuarios.id AND 
                             (amisusuarios.nombre LIKE ? OR amisusuarios.apellido LIKE ? OR usuarios.usuario LIKE ?)";
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('sss', $buscador, $buscador, $buscador);
            } else {
                $consulta = "SELECT usuarios.usuario, amisusuarios.id, id_usuario, amisusuarios.nombre, amisusuarios.apellido, amisusuarios.fecha_nac 
                             FROM amisusuarios, usuarios 
                             WHERE id_usuario = usuarios.id";
                $sentencia = $this->conn->getConn()->prepare($consulta);
            }
        
            $sentencia->execute();
            $sentencia->bind_result($usuario, $this->id, $this->id_usuario, $this->nombre, $this->apellidos, $this->fecha_nac);
        
            $amigosUsu = array();
            while ($sentencia->fetch()) {
                $amigosUsu[] = array(
                    "id" => $this->id,
                    "id_usuario" => $this->id_usuario,
                    "nombre" => $this->nombre,
                    "apellidos" => $this->apellidos,
                    "fecha_nac" => $this->fecha_nac,
                    "usuario" => $usuario
                );
            }
            $sentencia->close();
            return $amigosUsu;
        }

        public function getAmigosID($idU, $idAmi) {
            echo $idAmi;
            echo "<br>".$idU;
            $consulta = "SELECT * 
                        FROM amisusuarios 
                        WHERE id = ? AND id_usuario = ? ";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ii', $idU, $idAmi);
            $sentencia->execute();
            $sentencia->bind_result( $this->id, $this->nombre, $this->apellidos, $this->fecha_nac, $this->id_usuario,);
        
            $amigoUsu = array();
            $sentencia->fetch();
            $amigoUsu["id"] = $this->id;
            $amigoUsu["nombre"] = $this->nombre;
            $amigoUsu["apellidos"] = $this->apellidos;
            $amigoUsu["fecha_nac"] = $this->fecha_nac;
            $amigoUsu["id_usuario"] = $this->id_usuario;
            $sentencia->close();
            return $amigoUsu;
        }

        public function getIDAmigo($usuario, $amigo) {
            $consulta = "SELECT amisusuarios.id FROM amisusuarios, usuarios WHERE amisusuarios.id_usuario = usuarios.id AND usuarios.usuario = ? AND amisusuarios.id = ?;"; 
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ss', $usuario, $amigo);
            $sentencia->bind_result($this->id);
            $sentencia->execute();
            $sentencia->fetch();
            return $this->id;
        }

        public function modificarAmigo($n, $ap, $fn, $id, $iu) {
            $consulta = "UPDATE amisusuarios
                        SET nombre = ?, apellido = ?, fecha_nac = ?
                        WHERE id = ? AND id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('sssii', $n, $ap, $fn, $id, $iu);
            if($sentencia->execute()) return true;
            else return false;
        }

        public function insertarAmigo() {
            $consulta = "INSERT INTO amisusuarios (id_usuario, nombre, apellido, fecha_nac) VALUES (?, ?, ?, ?)";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ssss', $this->id_usuario, $this->nombre, $this->apellidos, $this->fecha_nac);
            if($sentencia->execute()) return true;
            else return false;
        }
    }

?>