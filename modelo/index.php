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
                if($usuario == "admin"){
                    require_once('../vista/homeAdmin.php'); // Mostramos la pagina
                }else require_once('../vista/home.php'); // Mostramos la pagina 
                
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
            
            if(compContraseñaRegister($c1, $c2)){
                $u = $_POST["usuario"];
                require_once('../controlador/class.usuario.php');
                $user = new usuario(0, $u, $c1);
                if($user->registrarUsuario()){
                    $msg = "<p class='msg'>Usuario creado con éxito</p>";
                    usuariosAdmin();
                }
            }
        }
    }

    function compContraseñaRegister($c1, $c2){ // Funcion para comprobar si las contraseñas coinciden
        if ($c1 != $c2) { // Si las contraseñas no coinciden
            $msg = "<p class='msg'>Las contraseñas no coinciden</p>"; // Si las contraseñas no coinciden
            require_once('../vista/register.php'); // Mostramos la pagina de registro
            return false;
        }
        $patronEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $email = 'correo@example.com';

        if (preg_match($patronEmail, $email)) {
            echo "El correo es válido.";
        } else {
            echo "El correo no es válido.";
        }
        return true;
    }

    function register(){ // Funcion para mostrar la pagina de registro
        require_once('../vista/register.php'); // Mostramos la pagina de registro
    }

    // AMIGOS.PHP
    
    /**
     * Funcion para mostrar la pagina de amigos
     * Muestra la pagina con todos los amigos del usuario logueado
     * Si se ha pulsado el boton de buscar muestra la pagina con los resultados de la busqueda
     */
    function amigos(){
        require_once('../controlador/class.usuario.php');
        require_once('../controlador/class.amisusu.php');
        $user = get_session("usuario");
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
    /**
     * Funcion para mostrar la pagina de insertar amigos
     * Muestra la pagina con un formulario para insertar un nuevo amigo
     */
    function insertAmigo(){
        require_once('../controlador/class.amisusu.php');
        $usuario = get_session("usuario");
        $amis = new amiUsus();
        require_once('../vista/componentes/header.php');
        require_once('../vista/insertarAmigos.php');
        require_once('../vista/componentes/footer.html');
        
    }
/**
 * Funcion para añadir un nuevo amigo al usuario logueado.
 * Comprueba si se han proporcionado los datos requeridos (nombre, apellido, fecha).
 * Valida que los campos no estén vacíos y que la fecha proporcionada sea anterior a la actual.
 * Si la validación es exitosa, inserta al amigo en la base de datos.
 * Si falta algún dato o la fecha es incorrecta, muestra un mensaje de error y recarga la página de inserción.
 */


    function añadirAmigos() {
        $usuario = get_session("usuario");
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
    
            $usuario = get_session("usuario");
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
    function volverAmigos(){
        $usuario = get_session("usuario");
        amigos();
    }

    function volverAmigosAdmin(){
        $usuario = get_session("usuario");
        amigosAdmin();
    }

    // MODIFICAR AMIGOS
    
/**
 * Modifica la información de un amigo en la base de datos.
 * 
 * La función utiliza el parámetro "action" de la solicitud para determinar qué amigo
 * se va a modificar, recuperando su ID y el ID del usuario. Luego, obtiene los datos
 * del amigo de la base de datos. Dependiendo de si el usuario actual es un administrador
 * o no, carga diferentes vistas para permitir la modificación de los detalles del amigo.
 * 
 * Requiere que estén definidas las clases amiUsus y usuario, y que existan las vistas
 * correspondientes para la modificación de amigos.
 */

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
            $usuario = get_session("usuario");

            if($usuario == "admin"){
                $amiUsu = new amiUsus();
                require_once('../controlador/class.usuario.php');
                $usu = new usuario();
                $usuarios = $usu->getIdUsuarios();
                $amigosdeUsuario = $amiUsu->getAmigosAdmin($usuario);
                require_once('../vista/componentes/headerAdmin.php');
                require_once('../vista/modificarAmigosAdmin.php');
                require_once('../vista/componentes/footer.html');
            }else{
                require_once('../vista/componentes/header.php');
                require_once('../vista/modificarAmigos.php');
                require_once('../vista/componentes/footer.html');
            }

        }
    }
    // CAMBIAR A LOS NUEVOS DATOS DEL AMIGO
    /**
     * Funcion que se encarga de modificar un amigo en la base de datos.
     * Comprueba si la fecha proporcionada es valida y anterior a hoy, si no muestra un mensaje de error.
     * Modifica el amigo en la base de datos y luego muestra la vista de amigos.
     */
function modificarAmigo(){
        $nuevoNom = $_POST["nuevoNom"];
        $nuevoApe = $_POST["nuevoApe"];
        $idAmi = $_POST["idAmi"];
        $idUsu = $_POST["idUsu"];

        $fechaUsuario = new DateTime($_POST["nuevaFech"]); // Asume formato YYYY-MM-DD del input type="date"
        $fechaHoy = new DateTime();

        // Comprobar si la fecha es válida y anterior a hoy
        if ($fechaUsuario >= $fechaHoy) {
            $msg = "<p class='msg'>La fecha debe ser anterior a hoy.</p>";
            amigos();
        }

        require_once('../controlador/class.amisusu.php');
        $amis = new amiUsus();
        $amigoUsu = $amis->modificarAmigo($nuevoNom, $nuevoApe, $fechaUsuario->format('Y-m-d'), $idAmi, $idUsu);
        $usuario = get_session("usuario");
        // Mostrar vista de amigos
        amigos();
    }
    
    // BUSCAR AMIGOS
    function buscarAmigos(){
        $usuario = get_session("usuario");
        require_once('../vista/componentes/header.php');
        require_once('../vista/buscarAmigos.php');
        require_once('../vista/componentes/footer.html');
    }

    // JUEGOS
    
    /**
     * Funcion que se encarga de mostrar los juegos de un usuario.
     * Recibe un parametro opcional que es el buscador de juegos.
     * Muestra la vista de juegos con los juegos del usuario.
     */
    function juegos(){
        $usuario = get_session("usuario");
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
        $usuario = get_session("usuario");
        require_once('../vista/componentes/header.php');
        require_once('../vista/insertarJuegos.php');
        require_once('../vista/componentes/footer.html');
    }

    // BUSCAR JUEGOS
    function buscarJuegos(){
        $usuario = get_session("usuario");
        require_once('../vista/componentes/header.php');
        require_once('../vista/buscarJuegos.php');
        require_once('../vista/componentes/footer.html');
    }
    function buscarPrestamo(){
        $usuario = get_session("usuario");
        require_once('../vista/componentes/header.php');
        require_once('../vista/buscarPresupuesto.php');
        require_once('../vista/componentes/footer.html');
    }

    /**
     * Funcion que se encarga de agregar un juego a la base de datos.
     * Comprueba si se ha proporcionado un nombre de juego, si no muestra un mensaje de error.
     * Comprueba si se ha proporcionado un año, si no muestra un mensaje de error.
     * Comprueba si se ha proporcionado una imagen, si no muestra un mensaje de error.
     * Comprueba si la imagen pesa menos de 2MB, si no muestra un mensaje de error.
     * Si se han proporcionado todos los campos necesarios, se inserta el juego en la base de datos.
     * Si el juego se ha insertado con exito, muestra un mensaje de exito y redirige a la pagina principal, si no muestra un mensaje de error.
     */
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
            $usuario = get_session("usuario");
            $ruta = "../img/".$usuario."/";
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
        $usuario = get_session("usuario");
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
            $usuario = get_session("usuario");

            require_once('../vista/componentes/header.php');
            require_once('../vista/modificarJuego.php');
            require_once('../vista/componentes/footer.html');
        }
    }

// CAMBIOS DE JUEGO
/**
 *  LA FUNCION DE CAMBIOS DE JUEGO SE ENCARGA DE MODIFICAR UN JUEGO EN LA BASE DE DATOS
 *  RECIBE UN PARAMETRO OPCIONAL QUE ES EL BUSCADOR DE JUEGOS
 *  MUESTRA LA VISTA DE JUEGOS CON LOS JUEGOS DEL USUARIO
 */

function cambiosJuego(){
        require_once('../controlador/class.juego.php');
        $juego = new juego();
        
        $id = $_POST["idJuego"];
        $id_usario = $_POST["idUsu"];
        $nuevoNom = $_POST["nuevoNom"];
        $nuevoAnio = $_POST["nuevoAnio"];
        $nuevoPlataforma = $_POST["plataforma"];
        $usuario = get_session("usuario");
        $ruta = "../img/".$usuario."/";
        $destino = $ruta.$nuevoNom;
        $origen = "";
        if(!empty($_FILES["img"]["tmp_name"])){
            
            $urlFoto = $juego->getRuta($id);
            // Verificar si el archivo existe
            if (file_exists($urlFoto)) unlink($urlFoto);

            $formato = $_FILES["img"]["type"];
            $formato = explode("/", $formato);
            $destino = $destino.".".$formato[1];
            $origen = $_FILES["img"]["tmp_name"];
            move_uploaded_file($origen, $destino);
        }else{
            $destino = $_POST["url"];
        }

        $juego->modificarJuego($nuevoNom, $nuevoPlataforma, $destino, $nuevoAnio, $id, $id_usario);
        juegos();
    }

    // PRESTAMOS

/**
 * La funcion prestamos se encarga de mostrar la vista de prestamos,
 * mostrando los prestamos del usuario logueado.
 * Recibe un parametro opcional que es el buscador de prestamos.
 * Muestra la vista de prestamos con los prestamos del usuario.
 */
    function prestamos(){
        $usuario = get_session("usuario");
        require_once('../controlador/class.prestamo.php');
        $buscador = "";
        if(isset($_POST["buscador"])) $buscador = $_POST["buscador"];
        $pres = new prestamo();
        $prestamos = $pres->getPrestamo($usuario, $buscador);
        require_once('../vista/componentes/header.php');
        require_once('../vista/prestamos.php');
        require_once('../vista/componentes/footer.html');
    }

    function InsertarPrestamo(){
        require_once('../controlador/class.amisusu.php');
        require_once('../controlador/class.juego.php');
        require_once('../controlador/class.usuario.php');
        
        $usuario = get_session("usuario");
        $amiUsu = new amiUsus();
        $juegos = new juego();

        $amigosdeUsuario = $amiUsu->getAmigos($usuario);
        $juegosdeUsuario = $juegos->getJuegosLibres($usuario);

        require_once('../vista/componentes/header.php');
        require_once('../vista/insertarPrestamos.php');
        require_once('../vista/componentes/footer.html');
    }

    /**
     * Funcion que se encarga de agregar un prestamo a la base de datos.
     * Comprueba si se ha proporcionado una fecha y si es valida, si no muestra un mensaje de error.
     * Comprueba si se han proporcionado los campos necesarios para insertar el prestamo, si no muestra un mensaje de error.
     * Extrae el ID del usuario, el ID del juego y el ID del amigo y los utiliza para insertar el prestamo en la base de datos.
     * Si el prestamo se ha realizado con exito muestra un mensaje de exito y redirige a la pagina principal, si no muestra un mensaje de error.
     */
    function añadirPrestamo(){
        $usuario = get_session("usuario");
        if(!isset($_POST["fech"])){
            $msg = "<p class='msg'>Debes insertar una fecha</p>";
            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarPrestamos.php');
            require_once('../vista/componentes/footer.html');
        }else{
            // Obtener la fecha proporcionada y la fecha actual
            $fechaUsuario = new DateTime($_POST["fech"]); // Asume formato YYYY-MM-DD del input type="date"
            $fechaHoy = new DateTime();

            // Comprobar si la fecha es válida, no es anterior a hoy y no supera 30 días
            $fechaMaxima = (clone $fechaHoy)->modify('+30 days');
    
            // Comprobar si la fecha es válida y anterior a hoy
            if ($fechaUsuario <= $fechaHoy) {
                $msg = "<p class='msg'>La fecha no debe ser anterior a hoy.</p>";
            }else if ($fechaUsuario > $fechaMaxima) {
                $msg = "<p class='msg'>La fecha no debe ser superior a 30 días desde hoy.</p>";
            }else if(isset($_POST["nombreAmigo"]) && isset($_POST["juego"]) && isset($_POST["fech"])){
                require_once('../controlador/class.prestamo.php');

                $amiUsuID = $_POST["nombreAmigo"];
                $juegoID = $_POST["juego"];
                $amiUsuID = intval($amiUsuID);
                $juegoID = intval($juegoID);
                $fecha = new DateTime($_POST["fech"]); // Asume formato YYYY-MM-DD del input type="date"
                
                // Extraer ID del usuario
                require_once('../controlador/class.usuario.php');
                $usu = new usuario(0,$usuario);
                $usuID = $usu->getIdUsu();

                $prestamo = new prestamo();
                if($prestamo->insertarPrestamo($usuID , $amiUsuID, $juegoID, $fecha->format('Y-m-d'))){
                    $msg = "<p class='msg'>Prestamo realizado con exito</p>";
                    prestamos();
                }else{
                    $msg = "<p class='msg'>Error al realizar el prestamo</p>";
                    $amiUsu = new amiUsus();
                    $juegos = new juego();

                    $amigosdeUsuario = $amiUsu->getAmigos($usuario);
                    $juegosdeUsuario = $juegos->getJuegos($usuario);

                    require_once('../vista/componentes/header.php');
                    require_once('../vista/insertarPrestamos.php');
                    require_once('../vista/componentes/footer.html');
                };
            }

            require_once('../controlador/class.amisusu.php');
            require_once('../controlador/class.juego.php');
            $amiUsu = new amiUsus();
            $juegos = new juego();

            $amigosdeUsuario = $amiUsu->getAmigos($usuario);
            $juegosdeUsuario = $juegos->getJuegosLibres($usuario);

            require_once('../vista/componentes/header.php');
            require_once('../vista/insertarPrestamos.php');
            require_once('../vista/componentes/footer.html');
        }
        
    }
    function modificarPrestamo(){
        $contador = $_REQUEST["action"];
        $contador = explode(" ", $contador);
        $i = "id_prestamo";
        $i = $i.$contador[1]; 

        if(isset($_POST[$i])){
            $id = $_POST[$i];
            require_once('../controlador/class.prestamo.php');
            $prestamo = new prestamo();
            if($prestamo->modificarPrestamo($id)){
                prestamos();
            }else{
                $msg = "<p class='msg'>Error al realizar el prestamo</p>";
                prestamos(); 
            }
        }else{
            prestamos();
        }
    }

    /////////////////////////////////// INICIO /////////////////////////////////////////
    /////////////////////////////////// ADMIN /////////////////////////////////////////

    /**
     * Funcion para mostrar la pagina de amigos de un administrador
     * Muestra la pagina con todos los amigos de los usuarios
     * Si se ha pulsado el boton de buscar muestra la pagina con los resultados de la busqueda
     */
    function amigosAdmin(){
        $usuario = get_session("usuario");
        require_once('../controlador/class.amisusu.php');
        $buscador = "";
        if(isset($_POST["buscador"])) $buscador = $_POST["buscador"];
        $amiUsu = new amiUsus();
        $amigos = $amiUsu->getAmigosAdmin($buscador);
        require_once('../vista/componentes/headerAdmin.php');
        require_once('../vista/amigosAdmin.php');
        require_once('../vista/componentes/footer.html');
    }


    /**
     * Funcion para mostrar la pagina de buscar amigos de un administrador
     * Muestra la pagina con un formulario para buscar amigos
     */
    function buscarAmigosAdmin(){
        $usuario = get_session("usuario");
        require_once('../vista/componentes/headerAdmin.php');
        require_once('../vista/buscarAmigosAdmin.php');
        require_once('../vista/componentes/footer.html');
    }

    // CERRAR SESION
    function cerrarSesion(){
        unset_session("usuario");
        require_once('../vista/login.php');
    }

    /**
     * Funcion para modificar un amigo en la base de datos.
     * Comprueba si la fecha proporcionada es valida y anterior a hoy, si no muestra un mensaje de error.
     * Modifica el amigo en la base de datos y luego muestra la vista de amigos.
     */
    function confirmarCambiosAdmin(){
        $nuevoNom = $_POST["nuevoNom"];
        $nuevoApe = $_POST["nuevoApe"];
        $idAmi = $_POST["idAmi"];
        $idUsu = $_POST["idUsu"];
        $idNewUser = $_POST["user"];
        $usuario = get_session("usuario");

        // Obtener la fecha proporcionada y la fecha actual
        $fechaUsuario = new DateTime($_POST["nuevaFech"]); // Asume formato YYYY-MM-DD del input type="date"
        $fechaHoy = new DateTime();

        // Comprobar si la fecha es válida y anterior a hoy
        if ($fechaUsuario >= $fechaHoy) {
            $msg = "<p class='msg'>La fecha debe ser anterior a hoy.</p>";
            amigosAdmin();
        }else{
            require_once('../controlador/class.amisusu.php');
            $amis = new amiUsus();
            $amigoUsu = $amis->modificarAmigoAdmin($nuevoNom, $nuevoApe, $fechaUsuario->format('Y-m-d'), $idAmi, $idUsu, $idNewUser);
            $usuario = get_session("usuario");
            // Mostrar vista de amigos
            amigosAdmin();
        }
    }

    /**
     * Funcion para mostrar la pagina de insertar amigos de un administrador
     * Muestra la pagina con un formulario para insertar un nuevo amigo
     * Si se ha pulsado el boton de buscar muestra la pagina con los resultados de la busqueda
     */
    function insertAmiAdmin(){
        require_once('../controlador/class.usuario.php');
        $usu = new usuario();
        $usuarios = $usu->getIdUsuarios();

        require_once('../controlador/class.amisusu.php');
        $usuario = get_session("usuario");
        $amis = new amiUsus();

        require_once('../vista/componentes/headerAdmin.php');
        require_once('../vista/insertarAmigosAdmin.php');
        require_once('../vista/componentes/footer.html');
    }

    /**
     * Funcion para mostrar la pagina de usuarios de un administrador
     * Muestra la pagina con todos los usuarios de la base de datos
     * Si se ha pulsado el boton de buscar muestra la pagina con los resultados de la busqueda
     */
    function usuariosAdmin(){
        $usuario = get_session("usuario");
        require_once('../controlador/class.usuario.php');
        $buscador = "";
        if(isset($_POST["buscador"])) $buscador = $_POST["buscador"];
        $usu = new usuario();
        $usuarios = $usu->getUsuarios($buscador);
        require_once('../vista/componentes/headerAdmin.php');
        require_once('../vista/usuariosAdmin.php');
        require_once('../vista/componentes/footer.html');
    }

    /**
     * Funcion para mostrar la pagina de modificar un usuario
     * Muestra la pagina con los datos del usuario a modificar
     * Si se ha pulsado el boton de guardar cambios muestra la pagina con los datos actualizados
     * @param int $id id del usuario a modificar
     * @return void
     */
    function ModificarUsuario(){
        $contador = $_REQUEST["action"];
        $contador = explode(" ", $contador);
        $i = "id";
        $i = $i.$contador[1]; 

        if(isset($_POST[$i])){
            $id = $_POST[$i];

            require_once('../controlador/class.usuario.php');
            $usu = new usuario();
            $usuario = $_POST["usuario"];
            $user = $usu->getUsu($id);
            require_once('../vista/componentes/headerAdmin.php');
            require_once('../vista/modificarUsuariosAdmin.php');
            require_once('../vista/componentes/footer.html');
        }
    }
    /**
     * Funcion para guardar los cambios en un usuario
     * Comprueba si se han proporcionado los campos necesarios para modificar el usuario, si no muestra un mensaje de error.
     * Modifica el usuario en la base de datos y luego muestra la vista de usuarios.
     * @return void
     */
    function guardarCambiosUsu(){
        $usuario = $_POST["usuario"];
        if(isset($_POST["nuevoUsu"], $_POST["nuevaCon"])){
            $nuevoUsu = $_POST["nuevoUsu"];
            $nuevaCon = $_POST["nuevaCon"];
            $idUsu = $_POST["idUsu"];

            require_once('../controlador/class.usuario.php');
            $usu = new usuario();
            if($amigoUsu = $usu->modificarUsuario($nuevoUsu, $nuevaCon, $idUsu)){
                usuariosAdmin();
            }else{
                $msg = "<p class='msg'>no se han hecho los cambios debido a un error</p>";
                usuariosAdmin();
            }
            
        }else{
            $msg = "<p class='msg'>Has tratado de mandar datos vacios</p>";
            usuariosAdmin();
        }
        
    }

    function buscaUsuario(){
        $usuario = $_POST["usuario"];
        require_once('../vista/componentes/headerAdmin.php');
        require_once('../vista/buscaUsuario.php');
        require_once('../vista/componentes/footer.html');
    }

    /**
     * Funcion para mostrar la pagina de insertar amigos de un administrador
     * Muestra la pagina con un formulario para insertar un nuevo amigo
     * Si se ha pulsado el boton de buscar muestra la pagina con los resultados de la busqueda
     * @return void
     */
    function añadirAmigosAdmin() {
        $usuario = $_POST["usuario"];
        if (isset($_POST["nombre"], $_POST["apellido"], $_POST["fecha"])) {
            // Validar que los campos no estén vacíos
            if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["fecha"])) {
                require_once('../controlador/class.usuario.php');
                $usu = new usuario();
                $usuarios = $usu->getIdUsuarios();

                require_once('../controlador/class.amisusu.php');
                $usuario = get_session("usuario");
                $amis = new amiUsus();
                $msg = "<p class='msg'>Todos los campos son obligatorios.</p>";
                require_once('../vista/componentes/headerAdmin.php');
                require_once('../vista/insertarAmigosAdmin.php');
                require_once('../vista/componentes/footer.html');
                return;
            }
    
            // Obtener la fecha proporcionada y la fecha actual
            $fechaUsuario = new DateTime($_POST["fecha"]); // Asume formato YYYY-MM-DD del input type="date"
            $fechaHoy = new DateTime();
    
            // Comprobar si la fecha es válida y anterior a hoy
            if ($fechaUsuario >= $fechaHoy) {
                $msg = "<p class='msg'>La fecha debe ser anterior a hoy.</p>";
                require_once('../controlador/class.usuario.php');
                $usu = new usuario();
                $usuarios = $usu->getIdUsuarios();

                require_once('../controlador/class.amisusu.php');
                $usuario = get_session("usuario");
                $amis = new amiUsus();
                require_once('../vista/componentes/headerAdmin.php');
                require_once('../vista/insertarAmigosAdmin.php');
                require_once('../vista/componentes/footer.html');
                return;
            }
    
            // Insertar amigo en la base de datos
            require_once('../controlador/class.amisusu.php');
            require_once('../controlador/class.usuario.php');
    
            $idUsu = $_POST["user"];
            // $usu = new usuario(0, $usuario);
            // $idUsu = $usu->getIdUsu();
            $amis = new amiUsus(0, $idUsu, $_POST["nombre"], $_POST["apellido"], $fechaUsuario->format('Y-m-d'));
            $amis->insertarAmigo();
            $usuario = get_session("usuario");
            $amisUsu = $amis->getAmigosAdmin(""); //
    
            // Mostrar vista de amigos
            amigosAdmin();
        } else {
            // Mostrar msg si faltan datos
            $msg = "<p class='msg'>Error al rellenar todos los campos</p>";
            require_once('../vista/componentes/headerAdmin.php');
            require_once('../vista/insertarAmigosAdmin.php');
            require_once('../vista/componentes/footer.html');
        }
    }

    function insertUsu(){
        // require_once('../vista/componentes/headerAdmin.php');
        require_once('../vista/register.php');
        // require_once('../vista/componentes/footer.html');
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
        if (strpos($action, "ModificarUsuario") !== false) $action = "ModificarUsuario";
        if (strpos($action, "Devolver") !== false) $action = "modificarPrestamo";
        if($action == "Guardar Cambios") $action = "modificarAmigo";
        if($action == "Buscar Juegos") $action = "buscarJuegos";
        if($action == "Insertar Juegos") $action = "insertJuegos";
        if($action == "Añadir juego") $action = "añadirJuego";
        if($action == "Insertar Prestamos") $action = "InsertarPrestamo";
        if($action == "Añadir prestamo") $action = "añadirPrestamo";
        if($action == "Buscar prestamos") $action = "buscarPrestamo";
        if($action == "Amigos ADMIN") $action = "amigosAdmin";
        if($action == "Juegos ADMIN") $action = "juegosAdmin";
        if($action == "Prestamos ADMIN") $action = "prestamosAdmin";
        if($action == "Buscar Amigos Admin") $action = "buscarAmigosAdmin";
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