<?php
require_once('class.db.php');
class usuario{
    private $conn;
    private $id;
    private $usuario;
    private $contrasenia;

    /**
     * Constructor de la clase usuario.
     * 
     * @param int $id [Opcional] ID del usuario en la base de datos. Por defecto es 0.
     * @param String $u [Opcional] Usuario. Por defecto cadena vacia.
     * @param String $c [Opcional] Contrasenia del usuario. Por defecto cadena vacia.
     */
    public function __construct(int $id=0, String $u="", String $c="") {
        $this->conn = new db();
        $this->id = $id;
        $this->usuario = $u;
        $this->contrasenia = $c;
    }

    /**
     * Comprueba si el usuario y la contrasenia son correctas.
     * 
     * La funcion devuelve true si el usuario y la contrasenia son correctas, y false en caso contrario.
     * 
     * @return boolean True si el usuario y la contrasenia son correctas, false en caso contrario.
     */
    public function login() {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasenia = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $this->usuario, $this->contrasenia);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        if($resultado->num_rows > 0) return true;
        else return false;
    }

    /**
     * Comprueba si el usuario y la contrasenia son correctas.
     * 
     * La funcion devuelve true si el usuario y la contrasenia son correctas, y false en caso contrario.
     * 
     * @param String $usu El nombre del usuario.
     * @param String $con La contrasenia del usuario.
     * @return bool True si el usuario y la contrasenia son correctas, false en caso contrario.
     */
    public function compContra($usu, $con){
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasenia = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $usu, $con);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        if($resultado->num_rows > 0) return true;
        else return false;
    }

    /**
     * Devuelve el ID de un usuario en la base de datos.
     * 
     * La funcion devuelve el ID del usuario que coincide con el nombre del usuario.
     * 
     * @return int El ID del usuario en la base de datos.
     */
    public function getIdUsu(){
        $consulta = "SELECT id FROM usuarios WHERE usuario = ?";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("s", $this->usuario);
        $sentencia->execute();
        $sentencia->bind_result($this->id);
        $sentencia->fetch();
        return $this->id;
    }
    /**
     * Obtiene un array con los ID y los nombres de los usuarios,
     * excepto el administrador.
     * 
     * La funcion devuelve un array de arrays, donde cada sub-array
     * contiene el ID y el nombre de cada usuario, excepto el administrador.
     * 
     * @return array Un array con los ID y los nombres de los usuarios.
     */
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
    /**
     * Registra un usuario en la base de datos.
     * 
     * La funcion registra el usuario que se encuentra en el objeto actual en la base de datos.
     * 
     * @return boolean True si se registro el usuario correctamente, false en caso contrario.
     */
    public function registrarUsuario(){
        $consulta = "INSERT INTO usuarios (usuario, contrasenia) VALUES (?,?);";
        $sentencia = $this->conn->getConn()->prepare($consulta);
        $sentencia->bind_param("ss", $this->usuario, $this->contrasenia);
        if($sentencia->execute()) return true;
        else return false;
    }

    /**
     * Devuelve un array de usuarios.
     * 
     * La funcion devuelve un array de usuarios. Cada usuario es un array con los siguientes campos:
     * - id: El ID del usuario.
     * - usuario: El nombre del usuario.
     * - contrasenia: La contrasenia del usuario, ocultada con asteriscos.
     * 
     * @param string $buscador [Opcional] Cadena de texto para buscar a los usuarios. Si se pasa, se buscan los usuarios que coincidan con el nombre del usuario.
     * @return array Un array de usuarios. Cada usuario es un array con los siguientes campos:
     *              - id: El ID del usuario.
     *              - usuario: El nombre del usuario.
     *              - contrasenia: La contrasenia del usuario, ocultada con asteriscos.
     */
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

    /**
     * Devuelve un array con los datos de un usuario.
     * 
     * La funcion devuelve un array con los datos del usuario con el ID pasado como parametro.
     * El array tiene los siguientes campos:
     * - id: El ID del usuario.
     * - usuario: El nombre del usuario.
     * - contrasenia: La contrasenia del usuario, ocultada con asteriscos.
     * 
     * @param int $i El ID del usuario que se va a buscar.
     * @return array Un array con los datos del usuario.
     */
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

/**
 * Modifica un usuario en la base de datos.
 *
 * La función utiliza los parámetros "usu", "con" e "i" para determinar 
 * qué usuario se va a modificar y qué datos se van a actualizar.
 * Devuelve true si la modificación fue exitosa, false en caso contrario.
 *
 * @param string $usu Nuevo nombre de usuario.
 * @param string $con Nueva contraseña del usuario.
 * @param int $i ID del usuario en la base de datos.
 * @return bool True si se ha podido modificar el usuario, false en caso contrario.
 */

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