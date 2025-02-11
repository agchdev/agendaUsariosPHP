<?php
    require_once('class.db.php');
    class amiUsus{
        private $conn;
        private $id;
        private $id_usuario;
        private $nombre;
        private $apellidos;
        private $fecha_nac;

        /**
         * Constructor de la clase.
         * 
         * @param int $id [Opcional] Id del amigo en la base de datos. Por defecto es 0.
         * @param int $iu [Opcional] Id del usuario que tiene al amigo en la base de datos. Por defecto es 0.
         * @param String $n [Opcional] Nombre del amigo. Por defecto es "".
         * @param String $ap [Opcional] Apellidos del amigo. Por defecto es "".
         * @param String $fn [Opcional] Fecha de nacimiento del amigo. Por defecto es "".
         */
        public function __construct(int $id=0, int $iu=0, String $n="", String $ap="", String $fn="") {
            $this->conn = new db();
            $this->id = $id;
            $this->id_usuario = $iu;
            $this->nombre = $n;
            $this->apellidos = $ap;
            $this->fecha_nac = $fn;
        }

     
        /**
         * Obtiene los amigos de un usuario en la base de datos.
         * 
         * La función devuelve un array de arrays, donde cada sub-array contiene los datos de cada amigo.
         * Los datos incluyen el ID del amigo en la base de datos, el ID del usuario al que pertenece el
         * amigo, el nombre, apellidos y fecha de nacimiento del amigo.
         * 
         * @param String $usuario Usuario que se va a buscar en la base de datos.
         * @param String $buscador [Opcional] Cadena de texto para buscar a los amigos. Por defecto es "".
         * @return array Un array de arrays, donde cada sub-array contiene los datos de cada amigo.
         */
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

        /**
         * Devuelve un array de amigos de todos los usuarios, excepto del administrador.
         * 
         * La función utiliza el parámetro "action" de la solicitud para determinar qué amigos
         * se van a mostrar, recuperando su ID y el ID del usuario. Luego, obtiene los datos
         * del amigo de la base de datos. Dependiendo de si el usuario actual es un administrador
         * o no, carga diferentes vistas para permitir la modificación de los detalles del amigo.
         * 
         * Requiere que estén definidas las clases amiUsus y usuario, y que existan las vistas
         * correspondientes para la modificación de amigos.
         * 
         * @param string $buscador Cadena de texto para buscar a los amigos. Por defecto es "".
         * @return array Un array de arrays, donde cada sub-array contiene los datos de cada amigo.
         */
        public function getAmigosAdmin($buscador = "") {
            $usuario = "";
            if ($buscador != "") {
                $consulta = "SELECT usuarios.usuario, amisusuarios.id, id_usuario, amisusuarios.nombre, amisusuarios.apellido, amisusuarios.fecha_nac 
                             FROM amisusuarios, usuarios 
                             WHERE id_usuario = usuarios.id AND usuarios.usuario != 'admin' AND
                             (amisusuarios.nombre LIKE ? OR amisusuarios.apellido LIKE ? OR usuarios.usuario LIKE ?)";
                $sentencia = $this->conn->getConn()->prepare($consulta);
        
                // Añade los comodines '%' al valor del buscador
                $buscador = "%" . $buscador . "%";
                $sentencia->bind_param('sss', $buscador, $buscador, $buscador);
            } else {
                $consulta = "SELECT usuarios.usuario, amisusuarios.id, id_usuario, amisusuarios.nombre, amisusuarios.apellido, amisusuarios.fecha_nac 
                             FROM amisusuarios, usuarios 
                             WHERE id_usuario = usuarios.id AND usuarios.usuario != 'admin'";
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
        
        /**
         * Obtiene un amigo de la base de datos.
         * 
         * La función utiliza los parámetros "id_usuario" y "id" de la solicitud para determinar qué amigo
         * se va a mostrar, recuperando su ID, nombre, apellidos, fecha de nacimiento y el ID del usuario.
         * La función devuelve un array con los datos del amigo.
         * 
         * @param int $idU ID del usuario que tiene al amigo en la base de datos.
         * @param int $idAmi ID del amigo en la base de datos.
         * @return array Un array con los datos del amigo.
         */
        public function getAmigosID($idU, $idAmi) {
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

        /**
         * Obtiene el ID de un amigo específico para un usuario dado.
         * 
         * La función consulta la base de datos para obtener el ID de un amigo asociado a un usuario específico.
         * Se utiliza el nombre de usuario y el ID del amigo para realizar la búsqueda.
         * 
         * @param string $usuario Nombre de usuario que tiene al amigo.
         * @param string $amigo ID del amigo a buscar.
         * @return int ID del amigo en la base de datos.
         */

        public function getIDAmigo($usuario, $amigo) {
            $consulta = "SELECT amisusuarios.id FROM amisusuarios, usuarios WHERE amisusuarios.id_usuario = usuarios.id AND usuarios.usuario = ? AND amisusuarios.id = ?;"; 
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ss', $usuario, $amigo);
            $sentencia->bind_result($this->id);
            $sentencia->execute();
            $sentencia->fetch();
            return $this->id;
        }

        /**
         * Modifica un amigo en la base de datos.
         * 
         * La función utiliza los parámetros "nombre", "apellido", "fecha_nac", "id" y "id_usuario" de la solicitud
         * para determinar qué amigo se va a modificar y qué datos se van a actualizar.
         * La función devuelve true si se ha podido modificar el amigo, false en caso contrario.
         * 
         * @param string $n Nuevo nombre del amigo.
         * @param string $ap Nuevos apellidos del amigo.
         * @param string $fn Nueva fecha de nacimiento del amigo.
         * @param int $id ID del amigo en la base de datos.
         * @param int $iu ID del usuario al que pertenece el amigo.
         * @return bool True si se ha podido modificar el amigo, false en caso contrario.
         */
        public function modificarAmigo($n, $ap, $fn, $id, $iu) {
            $consulta = "UPDATE amisusuarios
                        SET nombre = ?, apellido = ?, fecha_nac = ?
                        WHERE id = ? AND id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('sssii', $n, $ap, $fn, $id, $iu);
            if($sentencia->execute()) return true;
            else return false;
        }

        /**
         * Modifica un amigo en la base de datos.
         * 
         * La función utiliza los parámetros "nombre", "apellido", "fecha_nac", "id" y "id_usuario" de la solicitud
         * para determinar qué amigo se va a modificar y qué datos se van a actualizar.
         * La función devuelve true si se ha podido modificar el amigo, false en caso contrario.
         * 
         * @param string $n Nuevo nombre del amigo.
         * @param string $ap Nuevos apellidos del amigo.
         * @param string $fn Nueva fecha de nacimiento del amigo.
         * @param int $id ID del amigo en la base de datos.
         * @param int $iu ID del usuario al que pertenece el amigo.
         * @param int $inu ID del nuevo usuario que tendrá al amigo.
         * @return bool True si se ha podido modificar el amigo, false en caso contrario.
         */
        public function modificarAmigoAdmin($n, $ap, $fn, $id, $iu, $inu) {
            $consulta = "UPDATE amisusuarios
                        SET nombre = ?, apellido = ?, fecha_nac = ?, id_usuario=?
                        WHERE id = ? AND id_usuario = ?;";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('sssiii', $n, $ap, $fn, $inu, $id, $iu);
            if($sentencia->execute()) return true;
            else return false;
        }

        /**
         * Inserta un nuevo amigo en la base de datos.
         * 
         * La función utiliza los atributos "id_usuario", "nombre", "apellidos" y "fecha_nac" de la clase para
         * determinar qué amigo se va a insertar.
         * La función devuelve true si se ha podido insertar el amigo, false en caso contrario.
         * 
         * @return bool True si se ha podido insertar el amigo, false en caso contrario.
         */
        public function insertarAmigo() {
            $consulta = "INSERT INTO amisusuarios (id_usuario, nombre, apellido, fecha_nac) VALUES (?, ?, ?, ?)";
            $sentencia = $this->conn->getConn()->prepare($consulta);
            $sentencia->bind_param('ssss', $this->id_usuario, $this->nombre, $this->apellidos, $this->fecha_nac);
            if($sentencia->execute()) return true;
            else return false;
        }
    }

?>