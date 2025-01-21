<?php
    function login(){
        
        if(isset($_POST["usuario"]) && isset($_POST["contrasenia"])) {
            $u = $_POST["usuario"];
            $c = $_POST["contrasenia"];
            require_once('../controlador/class.usuario.php');
            $user = new usuario(0, $u, $c);
            if($user->login()) echo "<p>SESIÓN INICIADA</p>";
            else{
                $msg = "<p>Usuario o contraseña incorrectos</p>";
                require_once('../vista/login.php');
            }
        }else{
            $msg = "<p class='msg'>El usuario o la contrase&ntilde;a son incorrectos</p>";
            require_once('../vista/login.php');
        }
    }

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

    function compContraseñaRegister($c1, $c2){
        if ($c1 != $c2) {
            $msg = "<p class='msg'>Las contraseñas no coinciden</p>";
            require_once('../vista/register.php');
        }
    }

    function register(){
        require_once('../vista/register.php');
    }

    if(isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        require_once('../vista/login.php');
    }
?>