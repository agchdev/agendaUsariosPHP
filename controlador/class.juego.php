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

        public function __construct(int $id=0,String $ju="", String $pl="", String $url="", String $anio="", int $idUsu="") {
            $this->conn = new db(); 
            $this->juego = $ju;
            $this->id = $id;
            $this->plataforma = $pl;
            $this->urlFoto = $url;
            $this->anio_lanzamiento = $anio;
            $this->idUsuario = $idUsu;
        }

        public function getJuegos($usuario, $buscador = "") {
            if ($buscador != "") {
                $consulta = "SELECT juegos.id, juegos.juego, juegos.plataforma, juegos.url_foto, juegos.anio_lanzamiento, juegos.id_usuario FROM juegos, usuarios WHERE juegos.id_usuario = usuarios.id AND usuarios.usuario = ? AND (juegos.juego LIKE ? OR juegos.plataforma LIKE ?)";
                
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('ss', $usuario, $buscador);
            }else{
                $consulta = "SELECT juegos.id, juegos.juego, juegos.plataforma, juegos.url_foto, juegos.anio_lanzamiento, juegos.id_usuario FROM juegos, usuarios WHERE juegos.id_usuario = usuarios.id AND usuarios.usuario = ?";
                $sentencia = $this->conn->getConn()->prepare($consulta);
                $sentencia->bind_param('s', $usuario);
            }
            
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
    }
?>