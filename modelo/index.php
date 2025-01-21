<?php
    function login(){
        require_once('../controlador/class.usuario.php');

        if(isset($_POST["usuario"]) && isset($_POST["contrasenia"])) {
            $u = $_POST["usuario"];
            $c = $_POST["contrasenia"];
            $user = new usuario(0, $u, $c);
            $user->login();
        }else{
            $error = "<p class='error'>El usuario o la contrase&ntilde;a son incorrectos</p>";
            require_once('../vista/login.html');
        }
    }
    function register(){
        require_once('../vista/register.html');
    }

    if(isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
        $action();
    }else{
        require_once('../vista/login.html');
    }
?>