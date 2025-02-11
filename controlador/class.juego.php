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

        /**
         * Constructor de la clase juego.
         * @param int $i ID del juego. Por defecto 0.
         * @param string $ju Titulo del juego. Por defecto cadena vacia.
         * @param string $pl Plataforma donde se juega. Por defecto cadena vacia.
         * @param string $urlFoto URL de la portada del juego. Por defecto cadena vacia.
         * @param string $anio Anio de lanzamiento del juego. Por defecto cadena vacia.
         * @param int $idUsu ID del usuario al que pertenece el juego. Por defecto 0.
         */
        public function __construct($i=0 ,String $ju="", String $pl="", String $url="", String $anio="", $idUsu="") {
            $this->conn = new db(); 
            $this->id = $i;
            $this->juego = $ju;
            $this->plataforma = $pl;
            $this->urlFoto = $url;
            $this->anio_lanzamiento = $anio;
            $this->idUsuario = $idUsu;
        }

        /**
         * Funcion que devuelve los juegos de un usuario.
         * @param string $usuario Usuario que posee los juegos.
         * @param string $buscador Opcional. Buscador de juegos. Si se pasa, se buscan los juegos que coincidan con el titulo o la plataforma.
         * @return array Un array de juegos. Cada juego es un array con los siguientes campos:
         *              - id: El ID del juego.
         *              - juego: El titulo del juego.
         *              - plataforma: La plataforma del juego.
         *              - url: La URL de la portada del juego.
         *              - anio: El anio de lanzamiento del juego.
         *              - id_usuario: El ID del usuario que posee el juego.
         */
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

        /**
         * Obtiene los juegos de un usuario que no estan prestados.
         * 
         * La funcion devuelve un array de arrays, donde cada sub-array contiene los datos de cada juego.
         * Los datos incluyen el ID del juego en la base de datos, el nombre del juego, la plataforma, la URL
         * de la portada del juego y el anio de lanzamiento.
         * 
         * @param String $usuario El usuario que se va a buscar en la base de datos.
         * @param String $buscador [Opcional] Cadena de texto para buscar a los juegos. Por defecto es "".
         * @return array Un array de arrays, donde cada sub-array contiene los datos de cada juego.
         */
        
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

        /**
         * Obtiene el ID de un juego en la base de datos.
         * 
         * La función devuelve el ID del juego que coincide con el usuario y el nombre del juego.
         * Si no existe, devuelve 0.
         * 
         * @param String $usuario Usuario que se va a buscar en la base de datos.
         * @param String $juego Titulo del juego a buscar.
         * @return int El ID del juego en la base de datos.
         */
        public function getIDJuego($usuario, $juego) {
            $consulta = "SELECT juegos.id FROM juegos, usuarios WHERE juegos.id_usuario = usuarios.id AND usuarios.usuario = ? AND juegos.juego = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ss', $usuario, $juego);
            $sentencia->bind_result($this->id);
            $sentencia->execute();
            $sentencia->fetch();
            return $this->id;
        }

        /**
         * Inserta un juego en la base de datos.
         * 
         * La función devuelve verdadero si se ha podido insertar el juego en la base de datos, falso en caso contrario.
         * La función utiliza los atributos $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario.
         * 
         * @return boolean True si se ha podido insertar el juego en la base de datos, falso en caso contrario.
         */
        public function insertarJuego() {
            $consulta = "INSERT INTO juegos (juego, plataforma, urlFoto, anio_lanzamiento, id_usuario) VALUES (?,?,?,?,?)";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ssssi', $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario);
            if($sentencia->execute()) return true;
            else return false;
        }

        /**
         * Obtiene la ruta de la imagen de un juego en la base de datos.
         * 
         * La función devuelve la ruta de la imagen del juego que coincide con el ID.
         * Si no existe, devuelve un string vacío.
         * 
         * @param int $id El ID del juego en la base de datos.
         * @return string La ruta de la imagen del juego en la base de datos.
         */
        public function getRuta($id){
            $consulta = "SELECT urlFoto FROM juegos WHERE id = ?";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param("i", $id);
            $sentencia->execute();
            $sentencia->bind_result($this->urlFoto);
            $sentencia->fetch();
            return $this->urlFoto;
        }

        /**
         * Obtiene un juego de la base de datos.
         * 
         * La función devuelve un array con los campos del juego que coincide con el ID y el id_usuario.
         * La función utiliza los atributos $this->id, $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario.
         * 
         * @param int $id El ID del juego en la base de datos.
         * @param int $idUsu El ID del usuario que posee el juego.
         * @return array Un array con los campos del juego que coincide con el ID y el id_usuario.
         */
        public function getJuegoID($id, $idUsu) {
            $consulta = "SELECT juegos.id, juegos.juego, juegos.plataforma, juegos.urlFoto, juegos.anio_lanzamiento, juegos.id_usuario FROM juegos WHERE juegos.id = ? AND juegos.id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ii', $id, $idUsu);
            $sentencia->bind_result($this->id, $this->juego, $this->plataforma, $this->urlFoto, $this->anio_lanzamiento, $this->idUsuario);
            $sentencia->execute();

            $juegos = array(); //Cosillas
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

        /**
         * Modifica un juego en la base de datos.
         * 
         * La función utiliza los parámetros "juego", "plataforma", "urlFoto", "anio_lanzamiento", "id" y "id_usuario" de la solicitud
         * para determinar qué juego se va a modificar y qué datos se van a actualizar.
         * La función devuelve true si se ha podido modificar el juego, false en caso contrario.
         * 
         * @param String $j Nuevo título del juego.
         * @param String $p Nueva plataforma del juego.
         * @param String $u Nueva ruta de la portada del juego.
         * @param String $a Nuevo anio de lanzamiento del juego.
         * @param int $id ID del juego en la base de datos.
         * @param int $iu ID del usuario que posee el juego.
         * @return bool True si se ha podido modificar el juego, false en caso contrario.
         */
        public function modificarJuego($j, $p, $u, $a, $id, $iu) {
            $consulta = "UPDATE juegos SET juego = ?, plataforma = ? , urlFoto = ?, anio_lanzamiento = ? WHERE id = ? AND id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ssssii', $j, $p, $u, $a, $id, $iu);
            if($sentencia->execute()) return true;
            else return false;
        }
    }
?>