<?php
    require_once('class.db.php');
    class amiUsus{
        private $conn;
        private $id;
        private $id_usuario;
        private $nombre;
        private $fecha_nac;

        public function __construct(int $id=0, int $iu=0, String $n="", String $fn="") {
            $this->conn = new db();
            $this->id = $id;
            $this->id_usuario = $iu;
            $this->nombre = $n;
            $this->fecha_nac = $fn;
        }

        public function getAmigos($usuario) {
            $consulta = "SELECT * FROM amisusuarios, usuarios WHERE id_usuario = usarios.id AND usuario = ?";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('s', $usuario);
            $sentencia->execute();

            $amigosUsu = array();
            while($sentencia->fetch()){
                $amigosUsu[] = array(
                    "id" => $this->id,
                    "nombre" => $this->nombre,
                    "fecha_nac" => $this->fecha_nac
                );
            }
            return $amigosUsu;
        }
    }

?>