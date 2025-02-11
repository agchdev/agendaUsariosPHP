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

/**
 * Constructor de la clase prestamo.
 *
 * @param int $i [Opcional] ID del prestamo. Por defecto es 0.
 * @param int $iu [Opcional] ID del usuario que realiza el prestamo. Por defecto es 0.
 * @param int $ij [Opcional] ID del juego prestado. Por defecto es 0.
 * @param int $ia [Opcional] ID del amigo al que se presta el juego. Por defecto es 0.
 * @param String $fp [Opcional] Fecha del prestamo. Por defecto es "".
 * @param bool $d [Opcional] Estado del prestamo, si ha sido devuelto o no. Por defecto es false.
 */

        public function __construct(int $i=0, int $iu=0, int $ij=0, int $ia=0, String $fp="", bool $d=false) {
            $this->conn = new db();
            $this->id = $i;
            $this->id_usuario = $iu;
            $this->id_juego = $ij;
            $this->id_amisusu = $ia;
            $this->fecha_prestamo = $fp;
            $this->devuelto = $d;
        }

        /**
         * Inserta un prestamo en la base de datos.
         * 
         * La funcion inserta un prestamo en la base de datos, con los siguientes campos:
         * - id_usuario: El ID del usuario que realiza el prestamo.
         * - id_juego: El ID del juego prestado.
         * - id_ami: El ID del amigo al que se presta el juego.
         * - fecha_inicio: La fecha en la que se realiza el prestamo.
         * La funcion devuelve verdadero si se ha podido insertar el prestamo en la base de datos, falso en caso contrario.
         * 
         * @param int $idUsu ID del usuario que realiza el prestamo.
         * @param int $idAmi ID del amigo al que se presta el juego.
         * @param int $idJuego ID del juego prestado.
         * @param String $fechaPrestamo Fecha en la que se realiza el prestamo.
         * @return boolean True si se ha podido insertar el prestamo en la base de datos, falso en caso contrario.
         */
        public function insertarPrestamo($idUsu, $idAmi, $idJuego, $fechaPrestamo){
            $consulta = "INSERT INTO prestamos (id_usuario, id_juego, id_ami, fecha_inicio) VALUES (?, ?, ?, ?)";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('iiis', $idUsu, $idJuego, $idAmi, $fechaPrestamo);
            if($sentencia->execute()) return true;
            else return false;
        }

        /**
         * Obtiene los prestamos de un usuario.
         * 
         * La funcion devuelve un array de prestamos. Cada prestamo es un array con los siguientes campos:
         * - id: El ID del prestamo.
         * - id_usuario: El ID del usuario que realiza el prestamo.
         * - id_amigo: El ID del amigo al que se presta el juego.
         * - nombreAmigo: El nombre del amigo al que se presta el juego.
         * - nombreJuego: El nombre del juego prestado.
         * - urlFoto: La URL de la portada del juego.
         * - fecha_prestamo: La fecha en la que se realiza el prestamo.
         * - devuelto: El estado del prestamo, si ha sido devuelto o no.
         * 
         * @param String $usuario Usuario que se va a buscar en la base de datos.
         * @param String $buscador [Opcional] Buscador de prestamos. Si se pasa, se buscan los prestamos que coincidan con el nombre del amigo o el nombre del juego.
         * @return array Un array de prestamos. Cada prestamo es un array con los siguientes campos:
         *              - id: El ID del prestamo.
         *              - id_usuario: El ID del usuario que realiza el prestamo.
         *              - id_amigo: El ID del amigo al que se presta el juego.
         *              - nombreAmigo: El nombre del amigo al que se presta el juego.
         *              - nombreJuego: El nombre del juego prestado.
         *              - urlFoto: La URL de la portada del juego.
         *              - fecha_prestamo: La fecha en la que se realiza el prestamo.
         *              - devuelto: El estado del prestamo, si ha sido devuelto o no.
         */
        public function getPrestamo($usuario, $buscador=""){
            $nombreAmigo="";
            $nombreJuego ="";
            $urlFoto = "";
            if ($buscador != "") {
                $consulta = "SELECT prestamos.id, prestamos.id_usuario, prestamos.id_ami, amisusuarios.nombre, juegos.juego, juegos.urlFoto, prestamos.fecha_inicio, prestamos.devuelta
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

        /**
         * Modifica el estado del prestamo a devuelto.
         * @param int $id El ID del prestamo a modificar.
         * @return boolean True si se ha podido modificar el prestamo, false en caso contrario.
         */
        public function modificarPrestamo($id){
            $consulta = "UPDATE prestamos SET devuelta = 1 WHERE id = ?";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param("i", $id);
            if($sentencia->execute()) return true;
            else return false;
        }
    }
?>