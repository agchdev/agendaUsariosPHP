<?php
    function login(){
        require_once('../controlador/class.usuario.php');

        if(isset($_POST["usuario"]) && isset($_POST["contrasenia"])) {
            $u = $_POST["usuario"];
            $c = $_POST["contrasenia"];
            $user = new usuario(0, $u, $c);
            if($user->login()) echo "<p>SESIÓN INICIADA</p>";
            else{
                $error = "<p>Usuario o contraseña incorrectos</p>";
                require_once('../vista/login.php');
            }
        }else{
            $error = "<p class='error'>El usuario o la contrase&ntilde;a son incorrectos</p>";
            require_once('../vista/login.php');
        }
    }

    function registarUsuario(){
        require_once('../controlador/class.usuario.php');
        
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