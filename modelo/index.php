<?php
    
    /**
     * Funcion para loguear un usuario
     * Comprueba si se ha pulsado el boton de login
     * Comprueba si se ha rellenado el campo de usuario y contraseña
     * Comprueba si la cookie de sesion existe y si se ha pulsado el checkbox
     * Establece la cookie de sesion si se ha pulsado el checkbox.
     * Llama a la funcion login() de la clase usuario.
     * Si el login es correcto muestra la pagina de inicio.
     * Si el login es incorrecto muestra la pagina de login con un mensaje de error.
     */
    function login(){
        
        if(isset($_POST["usuario"]) && isset($_POST["contrasenia"])) { // Si se ha pulsado el boton
            $usuario = $_POST["usuario"]; // Guardamos el usuario
            $c = $_POST["contrasenia"]; // Guardamos la contraseña
            
            if(!isset($_POST["rec"]) && isset($_COOKIE["usuario"])){
                unsetCookie($_COOKIE["usuario"]); // Si se ha pulsado el checkbox y la cookie existe la eliminamos
            }
            
            require_once('../controlador/class.usuario.php'); // Importamos la clase
            $user = new usuario(0, $usuario, $c); // Creamos el objeto
            
            if($user->login()){
                if(isset($_POST["rec"])){ 
                    _setcookie("usuario", $usuario);// Si se ha pulsado el checkbox establecemos la cookie
                } 
                
                set_session("usuario", $usuario); // Establecemos la sesion
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
        require_once('../controlador/class.usuario.php');
        require_once('../controlador/class.amisusu.php');
        $user = $_POST["usuario"];
        $usu = new usuario(0, 0, $user);
        $idUsu = $usu->getIdUsu();
        $usuario = get_session("usuario");
        $amis = new amiUsus();
        $buscador = "";
        if(isset($_POST["buscador"])) $buscador = $_POST["buscador"];
        $amigosUsu = $amis->getAmigos($usuario, $buscador);
        require_once('../vista/componentes/header.php');
        require_once('../vista/amigos.php');
        require_once('../vista/componentes/footer.html');
    }
    function insertAmigo(){
        require_once('../controlador/class.amisusu.php');
        $usuario = $_POST["usuario"];
        $amis = new amiUsus();
        require_once('../vista/componentes/header.php');
        require_once('../vista/insertarAmigos.php');
        require_once('../vista/componentes/footer.html');
        
    }
    function añadirAmigos() {
        $usuario = $_POST["usuario"];
        if (isset($_POST["nombre"], $_POST["apellido"], $_POST["fecha"])) {
            // Validar que los campos no estén vacíos
            if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["fecha"])) {
                $msg = "<p class='msg'>Todos los campos son obligatorios.</p>";
                require_once('../vista/componentes/header.php');
                require_once('../vista/insertarAmigos.php');
                require_once('../vista/componentes/footer.html');
                return;
            }
    
            // Obtener la fecha proporcionada y la fecha actual
            $fechaUsuario = new DateTime($_POST["fecha"]); // Asume formato YYYY-MM-DD del input type="date"
            $fechaHoy = new DateTime();
    
            // Comprobar si la fecha es válida y anterior a hoy
            if ($fechaUsuario >= $fechaHoy) {
                $msg = "<p class='msg'>La fecha debe ser anterior a hoy.</p>";
                require_once('../vista/componentes/header.php');
                require_once('../vista/insertarAmigos.php');
                require_once('../vista/componentes/footer.html');
                return;
            }
    
            // Insertar amigo en la base de datos
            require_once('../controlador/class.amisusu.php');
            require_once('../controlador/class.usuario.php');
    
            $usuario = $_POST["usuario"];
            $usu = new usuario(0, $usuario);
            $idUsu = $usu->getIdUsu();
            $amis = new amiUsus(0, $idUsu, $_POST["nombre"], $_POST["apellido"], $fechaUsuario->format('Y-m-d'));
            $amis->insertarAmigo();
            $amisUsu = $amis->getAmigos($usuario);
    
            // Mostrar vista de amigos
            amigos();
        } else {
            // Mostrar msg si faltan datos
            $msg = "<p class='msg'>Error al rellenar todos los campos</p>";
            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarAmigos.php');
            require_once('../vista/componentes/footer.html');
        }
    }

    // MODIFICAR AMIGOS
    function modificarAmi(){
        $contador = $_REQUEST["action"];
        $contador = explode(" ", $contador);
        $i = "id";
        $i = $i.$contador[1]; 

        $iU = "id_usuario";
        $iU = $iU.$contador[1];
        if(isset($_POST[$i])){
            $id = $_POST[$i];
            $id_usario = $_POST[$iU];

            require_once('../controlador/class.amisusu.php');
            $amis = new amiUsus();
            $amigoUsu = $amis->getAmigosID($id, $id_usario);
            $usuario = $_POST["usuario"];

            require_once('../vista/componentes/header.php');
            require_once('../vista/modificarAmigos.php');
            require_once('../vista/componentes/footer.html');
        }
    }

    // CAMBIAR A LOS NUEVOS DATOS DEL AMIGO
    function modificarAmigo(){
        $nuevoNom = $_POST["nuevoNom"];
        $nuevoApe = $_POST["nuevoApe"];
        $nuevaFech = $_POST["nuevaFech"];
        $idAmi = $_POST["idAmi"];
        $idUsu = $_POST["idUsu"];

        require_once('../controlador/class.amisusu.php');
        $amis = new amiUsus();
        $amigoUsu = $amis->modificarAmigo($nuevoNom, $nuevoApe, $nuevaFech, $idAmi, $idUsu);
        $usuario = $_POST["usuario"];
        // Mostrar vista de amigos
        amigos();
    }
    
    // BUSCAR AMIGOS
    function buscarAmigos(){
        $usuario = $_POST["usuario"];
        require_once('../vista/componentes/header.php');
        require_once('../vista/buscarAmigos.php');
        require_once('../vista/componentes/footer.html');
    }

    // JUEGOS
    function juegos(){
        $usuario = $_POST["usuario"];
        require_once('../controlador/class.juego.php');
        $buscador = "";
        if(isset($_POST["buscador"])) $buscador = $_POST["buscador"];
        $juego = new juego();
        $juegos = $juego->getJuegos($usuario, $buscador);
        require_once('../vista/componentes/header.php');
        require_once('../vista/juegos.php');
        require_once('../vista/componentes/footer.html');
    }

    // INSERTAR JUEGOS
    function insertJuegos(){
        $usuario = $_POST["usuario"];
        require_once('../vista/componentes/header.php');
        require_once('../vista/insertarJuegos.php');
        require_once('../vista/componentes/footer.html');
    }

    // BUSCAR JUEGOS
    function buscarJuegos(){
        $usuario = $_POST["usuario"];
        require_once('../vista/componentes/header.php');
        require_once('../vista/buscarJuegos.php');
        require_once('../vista/componentes/footer.html');
    }

    function añadirJuego(){
        if(!isset($_POST["juego"])){
            $msg = "<p class='msg'>Inserta un nombre de juego</p>";
            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarJuegos.php');
            require_once('../vista/componentes/footer.html');
        }elseif(!isset($_POST["anio"])){
            $msg = "<p class='msg'>Inserta un año</p>";
            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarJuegos.php');
            require_once('../vista/componentes/footer.html');
        }elseif(empty($_FILES["img"]["tmp_name"])){
            $msg = "<p class='msg'>".$_FILES["img"]["tmp_name"]."</p>";
            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarJuegos.php');
            require_once('../vista/componentes/footer.html');
            return;
        }elseif(($_FILES["img"]["size"]/(2**20)) >= 2){ 
            $msg = "<p class='msg'>La imagen debe pesar menos de 2MB</p>";
            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarJuegos.php');
            require_once('../vista/componentes/footer.html');
            return;
        }else{
            $ruta = "./imgs/";
            if(!file_exists($ruta)){
                mkdir($ruta);
            }

            $nomNuevo = $_POST["juego"];
            $origen = $_FILES["img"]["tmp_name"];
            $destino = $ruta.$nomNuevo;

            move_uploaded_file($origen, $destino);
        }
        require_once('../controlador/class.juego.php');
        require_once('../controlador/class.usuario.php');
        $usuario = $_POST["usuario"];
        $usu = new usuario(0, $usuario);
        $idUsu = $usu->getIdUsu();
        $tit = $_POST["juego"];
        $anio = $_POST["anio"];
        $plataforma = $_POST["plataforma"];
        $juego = new juego(0, $tit, $plataforma, $destino,$anio, $idUsu);
        $juego->insertarJuego();

        juegos();
    }

    function modificarJuego(){
        $contador = $_REQUEST["action"];
        $contador = explode(" ", $contador);
        $i = "id";
        $i = $i.$contador[1]; 

        $iU = "id_usuario";
        $iU = $iU.$contador[1];
        if(isset($_POST[$i])){
            $id = $_POST[$i];
            $id_usario = $_POST[$iU];

            require_once('../controlador/class.juego.php');
            $juegos = new juego();
            $juego = $juegos->getJuegoID($id, $id_usario);
            $usuario = $_POST["usuario"];

            require_once('../vista/componentes/header.php');
            require_once('../vista/modificarAmigos.php');
            require_once('../vista/componentes/footer.html');
        }
    }

    // CERRAR SESION
    function cerrarSesion(){
        unset_session("usuario");
        require_once('../vista/login.php');
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
    function unset_session(String $nom) { // Esta funcion elimina una sesion
        start_session(); // Iniciamos la sesion
        session_unset(); // Esta funcion elimina una sesion
        session_destroy(); // Esta funcion destruye una sesion
    }

    function is_session(String $nom){ // Esta funcion comprueba si hay una sesion
        start_session();
        $isset = isset($_SESSION[$nom]); // Esta funcion comprueba si hay una sesion
        return $isset; // Devolvemos el valor de la variable
    }
    //////////////////////////// COOKIES // SESSIONES //////////////////////////////////
    /////////////////////////////////// FIN ////////////////////////////////////////////
    function hola(){
        echo "hola";
    }
    // INICIO
    if(isset($_REQUEST["action"])) { // Si se ha pulsado algun boton
        $action = $_REQUEST["action"]; // Guardamos la accion
        
        if($action == "Amigos") $action = "amigos";
        if($action == "Juegos") $action = "juegos";
        if($action == "Prestamos") $action = "prestamos";
        if($action == "Cerrar Sesion") $action = "cerrarSesion";
        if($action == "Insertar Amigo") $action = "insertAmigo";
        if($action == "Buscar Amigos") $action = "buscarAmigos";
        if($action == "Añadir amigo") $action = "añadirAmigos";
        if (strpos($action, "ModificarAmigo") !== false) $action = "modificarAmi";
        if (strpos($action, "ModificarJuego") !== false) $action = "modificarJuego";
        if($action == "Guardar Cambios") $action = "modificarAmigo";
        if($action == "Buscar Juegos") $action = "buscarJuegos";
        if($action == "Insertar Juegos") $action = "insertJuegos";
        if($action == "Añadir juego") $action = "añadirJuego";
        $action(); // Ejecutamos la accion
    }else{
        if (is_session("usuario")) { // Si la sesion de usuario existe
            $idUsu = get_session("usuario"); // Creamos la variable de sesion
            require_once('../vista/home.php'); // Redirigimos al login
        }else{
            require_once('../vista/login.php'); // Redirigimos al login
        }
    }
?>