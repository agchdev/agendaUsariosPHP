<?php
    
    /**
     * Funcion para loguear un usuario
     * Comprueba si se ha pulsado el boton de login
     * Comprueba si se ha rellenado el campo de usuario y contraseña
     * Comprueba si la cookie de sesion existe y si se ha pulsado el checkbox
     * Establece la cookie de sesion si se ha pulsado el checkbox
     * Llama a la funcion login() de la clase usuario
     * Si el login es correcto muestra la pagina de inicio
     * Si el login es incorrecto muestra la pagina de login con un mensaje de error
     */
    function login(){
        
        if(isset($_POST["usuario"]) && isset($_POST["contrasenia"])) { // Si se ha pulsado el boton
            $u = $_POST["usuario"]; // Guardamos el usuario
            $c = $_POST["contrasenia"]; // Guardamos la contraseña
            
            if(!isset($_POST["rec"]) && isset($_COOKIE["usuario"])){
                unsetCookie($_COOKIE["usuario"]); // Si se ha pulsado el checkbox y la cookie existe la eliminamos
            }
            
            require_once('../controlador/class.usuario.php'); // Importamos la clase
            $user = new usuario(0, $u, $c); // Creamos el objeto
            
            if($user->login()){
                if(isset($_POST["rec"])){ 
                    _setcookie("usuario", $u);// Si se ha pulsado el checkbox establecemos la cookie
                } 
                
                set_session("usuario", $u); // Establecemos la sesion
                require_once('../vista/home.php'); // Mostramos la pagina

            } // Si el login es correcto
            else{ // Si el login es incorrecto
                $msg = "<p>Usuario o contraseña incorrectos</p>"; // Mostramos un mensaje
                require_once('../vista/login.php'); // Mostramos la pagina
            }
        }else{ // Si no se ha pulsado el boton
            $msg = "<p class='msg'>El usuario o la contrase&ntilde;a son incorrectos</p>"; // Mostramos un mensaje
            require_once('../vista/login.php'); // Mostramos la pagina
        }
    }

    /**
     * Funcion para registrar un usuario
     * Comprueba si se han rellenado todos los campos
     * Comprueba si las contraseñas coinciden
     * Crea un objeto de tipo usuario
     * Llama a la funcion registrarUsuario() de la clase usuario
     * Si el registro es correcto muestra un mensaje de exito y redirige a la pagina de login
     */
    function registarUsuario(){
        if(isset($_POST["usuario"]) && isset($_POST["contrasenia"]) && isset($_POST["contrasenia2"])){
            $c1 = $_POST["contrasenia"];
            $c2 = $_POST["contrasenia2"];
            compContraseñaRegister($c1, $c2);
            $u = $_POST["usuario"];
            require_once('../controlador/class.usuario.php');
            $user = new usuario(0, $u, $c1);
            if($user->registrarUsuario()){
                $msg = "<p class='msg'>Usuario creado con éxito</p>";
                require_once('../vista/login.php');
            }
        }
    }

    function compContraseñaRegister($c1, $c2){ // Funcion para comprobar si las contraseñas coinciden
        if ($c1 != $c2) { // Si las contraseñas no coinciden
            $msg = "<p class='msg'>Las contraseñas no coinciden</p>"; // Si las contraseñas no coinciden
            require_once('../vista/register.php'); // Mostramos la pagina de registro
        }
    }

    function register(){ // Funcion para mostrar la pagina de registro
        require_once('../vista/register.php'); // Mostramos la pagina de registro
    }

    // AMIGOS.PHP
    function amigos(){
        require_once('../controlador/class.amisusu.php');
        $idUsu = $_POST["usuario"];
        $usuario = get_session("usuario");
        echo $idUsu;
        $amis = new amiUsus();
        $amigosUsu = $amis->getAmigos($usuario);
        require_once('../vista/amigos.php');
    }
    /////////////////////////////////// INICIO /////////////////////////////////////////
    //////////////////////////// COOKIES // SESSIONES //////////////////////////////////
    function unsetCookie(String $nom) { // Esta funcion elimina una cookie
        $comp = false; // Variable para comprobar si la cookie existe
        if(isset($_COOKIE[$nom])) { // Si la cookie existe
            setcookie($nom, "", time()-30); // Eliminamos la cookie
        }else{
            $comp = true; // La cookie no existe
        }
        return $comp; // Devolvemos el valor de la variable
    }

    function _setcookie(String $nom, $val) { // Esta funcion establece una cookie
        setcookie($nom, $val, time()+(86400*30)); // Esta funcion establece una cookie con un tiempo de vida de 30 dias
    }

    function start_session() { // Esta funcion inicia una sesion
        if(session_status() == PHP_SESSION_NONE) { // Si la sesion no esta iniciada
            session_start(); // Iniciamos la sesion
        }    
    }

    function set_session(String $nom, $val) { // Esta funcion establece una sesion
        start_session();
        $_SESSION[$nom] = $val; // Esta funcion establece una sesion
    }

    function get_session(String $nom){ // Esta funcion obtiene una sesion
        start_session();
        return $_SESSION[$nom]; // Esta funcion obtiene una sesion
    }

    function is_session(String $nom){ // Esta funcion comprueba si hay una sesion
        start_session();
        $isset = isset($_SESSION[$nom]); // Esta funcion comprueba si hay una sesion
        return $isset; // Devolvemos el valor de la variable
    }
    //////////////////////////// COOKIES // SESSIONES //////////////////////////////////
    /////////////////////////////////// FIN ////////////////////////////////////////////

    // INICIO
    if(isset($_REQUEST["action"])) { // Si se ha pulsado algun boton
        $action = $_REQUEST["action"]; // Guardamos la accion
        if($action == "Amigos") $action = "amigos";
        if($action == "Juegos") $action = "juegos";
        if($action == "Prestamos") $action = "prestamos";
        if($action == "Cerrar Sesion") $action = "cerrarSesion";
        $action(); // Ejecutamos la accion
    }else{
        if (is_session("usuario")) { // Si la sesion de usuario existe
            $idUsu = get_session("usuario"); // Creamos la variable de sesion
            $usuario = get_session("usuario");
            require_once('../vista/home.php'); // Redirigimos al login
        }else{
            require_once('../vista/login.php'); // Redirigimos al login
        }
    }
?>