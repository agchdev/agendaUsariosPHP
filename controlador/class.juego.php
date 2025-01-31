<?php
    require_once('class.db.php');
    class juego{
        private $conn;
        private $id;
        private $juego;
        private $plataforma;
        private $urlFoto;
        private $anio_lanzamiento;
        private $idUsuario;

        public function __construct($i=0 ,String $ju="", String $pl="", String $url="", String $anio="", $idUsu="") {
            $this->conn = new db(); 
            $this->id = $i;
            $this->juego = $ju;
            $this->plataforma = $pl;
            $this->urlFoto = $url;
            $this->anio_lanzamiento = $anio;
            $this->idUsuario = $idUsu;
        }

        public function getJuegos($usuario, $buscador = "") {
            if ($buscador != "") {
                $consulta = "SELECT juegos.id, juegos.juego, juegos.plataforma, juegos.urlFoto, juegos.anio_lanzamiento, juegos.id_usuario FROM juegos, usuarios WHERE juegos.id_usuario = usuarios.id AND usuarios.usuario = ? AND (juegos.juego LIKE ? OR juegos.plataforma LIKE ?)";
                
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('sss', $usuario, $buscador, $buscador);
            }else{
                $consulta = "SELECT juegos.id, juegos.juego, juegos.plataforma, juegos.urlFoto, juegos.anio_lanzamiento, juegos.id_usuario FROM juegos, usuarios WHERE juegos.id_usuario = usuarios.id AND usuarios.usuario = ?";
                $sentencia = $this->conn->getConn()->prepare($consulta);
                $sentencia->bind_param('s', $usuario);
            }
            $sentencia->bind_result($this->id, $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario);
            $sentencia->execute();
            $juegos = array();
            while ($sentencia->fetch()) {
                $juegos[] = array(
                    "id" => $this->id,
                    "juego" => $this->juego,
                    "plataforma" => $this->plataforma,
                    "url" => $this->urlFoto,
                    "anio" => $this->anio_lanzamiento,
                    "id_usuario" => $this->idUsuario,
                );
            }
            return $juegos;
        }

        public function getJuegosLibres($usuario, $buscador = "") {
            if ($buscador != "") {
                $consulta = "SELECT j.id, j.juego, j.plataforma, j.urlFoto, j.anio_lanzamiento, j.id_usuario 
                            FROM juegos j, usuarios u 
                            WHERE j.id_usuario = u.id 
                            AND u.usuario = ? 
                            AND j.id NOT IN (SELECT id_juego 
                                            FROM prestamos 
                                            WHERE devuelta = 0)) 
                            AND (j.juego LIKE ? OR j.plataforma LIKE ?)";
                
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('sss', $usuario, $buscador, $buscador);
            }else{
                $consulta = "SELECT j.id, j.juego, j.plataforma, j.urlFoto, j.anio_lanzamiento, j.id_usuario 
                            FROM juegos j, usuarios u 
                            WHERE j.id_usuario = u.id 
                            AND u.usuario = ? 
                            AND j.id NOT IN (SELECT id_juego 
                                            FROM prestamos 
                                            WHERE devuelta = 0)";
                $sentencia = $this->conn->getConn()->prepare($consulta);
                $sentencia->bind_param('s', $usuario);
            }
            $sentencia->bind_result($this->id, $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario);
            $sentencia->execute();
            $juegos = array();
            while ($sentencia->fetch()) {
                $juegos[] = array(
                    "id" => $this->id,
                    "juego" => $this->juego,
                    "plataforma" => $this->plataforma,
                    "url" => $this->urlFoto,
                    "anio" => $this->anio_lanzamiento,
                    "id_usuario" => $this->idUsuario,
                );
            }
            return $juegos;
        }

        public function getIDJuego($usuario, $juego) {
            $consulta = "SELECT juegos.id FROM juegos, usuarios WHERE juegos.id_usuario = usuarios.id AND usuarios.usuario = ? AND juegos.juego = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ss', $usuario, $juego);
            $sentencia->bind_result($this->id);
            $sentencia->execute();
            $sentencia->fetch();
            return $this->id;
        }

        public function insertarJuego() {
            $consulta = "INSERT INTO juegos (juego, plataforma, urlFoto, anio_lanzamiento, id_usuario) VALUES (?,?,?,?,?)";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ssssi', $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario);
            if($sentencia->execute()) return true;
            else return false;
        }

        public function getJuegoID($id, $idUsu) {
            $consulta = "SELECT juegos.id, juegos.juego, juegos.plataforma, juegos.urlFoto, juegos.anio_lanzamiento, juegos.id_usuario FROM juegos WHERE juegos.id = ? AND juegos.id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ii', $id, $idUsu);
            $sentencia->bind_result($this->id, $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario);
            $sentencia->execute();

            $juegos = array();
            $sentencia->fetch();
            $juegos["id"] = $this->id;
            $juegos["juego"] = $this->juego;
            $juegos["plataforma"] = $this->plataforma;
            $juegos["url"] = $this->urlFoto;
            $juegos["anio"] = $this->anio_lanzamiento;
            $juegos["id_usuario"] = $this->idUsuario;
            $sentencia->close();
            return $juegos;
        }

        public function modificarJuego($j, $p, $u, $a, $id, $iu) {
            $consulta = "UPDATE juegos SET juego = ?, plataforma = ? , urlFoto = ?, anio_lanzamiento = ? WHERE id = ? AND id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ssssii', $j, $p, $u, $a, $id, $iu);
            if($sentencia->execute()) return true;
            else return false;
        }
    }
?>